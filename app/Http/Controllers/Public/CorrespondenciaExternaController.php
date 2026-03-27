<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CorrespondenciaExternaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Tipo;
use App\Models\Ciudad;
use App\Models\Radicado;
use App\Models\Empresa;

class CorrespondenciaExternaController extends Controller
{
    /**
     * Muestra el formulario público para enviar correspondencia
     */
    public function create()
    {
        $tipos = Tipo::all();
        $ciudades = Ciudad::with('departamento')->orderBy('ciudad_nom')->get();
        $empresas = Empresa::all();

        return view('public.correspondencia.enviar', compact('tipos', 'ciudades', 'empresas'));
    }

    /**
     * Procesa el envío del formulario público
     */
    public function store(CorrespondenciaExternaRequest $request)
    {
        $validated = $request->validated();
        
        $folios = $validated['folio'];
        $rutaArchivo = $this->handleFileUpload($request, 'archivo');
        $anexoData = $this->handleAnexoUpload($request);

        $nitEmpresa = $validated['empresa_destino'];
        $datosRemitente = $this->extractDatosRemitente($validated);

        DB::beginTransaction();

        try {
            $nuevoNumRadicado = $this->generateSecureRadicado($nitEmpresa);

            $radicado = Radicado::create([
                'num_radicado' => $nuevoNumRadicado,
                'nit_empresa'  => $nitEmpresa
            ]);

            $idRecibido = $this->insertRecibidoRecord($validated, $datosRemitente, $radicado->id_radicado, $rutaArchivo, $folios, $nitEmpresa);

            if ($anexoData) {
                DB::table('anexo_recibido')->insert([
                    'id_recibido'     => $idRecibido,
                    'ruta_archivo'    => $anexoData['ruta_archivo'],
                    'nombre_original' => $anexoData['nombre_original'],
                ]);
            }

            DB::commit();

            $this->sendConfirmationEmail($datosRemitente['correo'], $nuevoNumRadicado);

            return redirect()->route('public.correspondencia.enviar')
                ->with('success', 'Correspondencia enviada exitosamente. Su número de radicado es: ' . $radicado->num_radicado . '. Se ha enviado un correo con esta información.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error registrando correspondencia pública: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error inesperado al procesar el envío: ' . $e->getMessage()]);
        }
    }

    /**
     * Muestra la vista de consulta de radicado
     */
    public function consultar()
    {
        return view('public.correspondencia.consultar');
    }

    /**
     * Busca la correspondencia y devuelve los datos
     */
    public function buscarRadicado(Request $request)
    {
        $request->validate([
            'numero_radicado'  => 'required|string',
            'tipo_remitente'   => 'required|in:Persona,Empresa',
        ]);

        $documentoBuscado = $this->validateAndGetDocumento($request);

        try {
            $resultado = $this->getRadicadoQuery($request, $documentoBuscado)->first();

            if (!$resultado) {
                return redirect()->back()->withInput()->withErrors(['error' => 'No se encontró correspondencia con los datos proporcionados. Verifique el radicado y el documento.']);
            }

            return view('public.correspondencia.consultar', compact('resultado'));

        } catch (\Exception $e) {
            Log::error('Error consultando correspondencia: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al realizar la consulta: ' . $e->getMessage()]);
        }
    }

    // ==========================================
    // MÉTODOS PRIVADOS PARA REFATORIZACIÓN DRY
    // ==========================================

    private function handleFileUpload(Request $request, $fieldName)
    {
        if ($request->hasFile($fieldName)) {
            return $request->file($fieldName)->store('correspondencia', 'public');
        }
        return null;
    }

    private function handleAnexoUpload(Request $request)
    {
        if ($request->hasFile('anexos')) {
            $archivosAnexos = $request->file('anexos');
            $anexoFile = is_array($archivosAnexos) ? ($archivosAnexos[0] ?? null) : $archivosAnexos;

            if ($anexoFile && $anexoFile->isValid()) {
                return [
                    'ruta_archivo'    => $anexoFile->store('correspondencia', 'public'),
                    'nombre_original' => $anexoFile->getClientOriginalName(),
                ];
            }
        }
        return null;
    }

    private function extractDatosRemitente($validated)
    {
        if ($validated['tipo_remitente'] === 'Empresa') {
            return [
                'doc'             => $validated['nit_empresa_remitente'],
                'nombre'          => $validated['nombre_empresa'],
                'correo'          => $validated['correo_empresa'],
                'tel'             => $validated['tel_empresa'] ?? null,
                'radicado_ext'    => $validated['radicado_empresa'],
                'tipo_doc'        => 'NIT',
                'nom_institucion' => $validated['nombre_empresa'],
                'nombre_persona'  => null
            ];
        }

        return [
            'doc'             => $validated['numero_documento'],
            'nombre'          => $validated['nombre_persona'],
            'correo'          => $validated['correo_persona'],
            'tel'             => $validated['tel_persona'] ?? null,
            'radicado_ext'    => null,
            'tipo_doc'        => $validated['tipo_documento'],
            'nom_institucion' => null,
            'nombre_persona'  => $validated['nombre_persona']
        ];
    }

    private function generateSecureRadicado($nitEmpresa)
    {
        $currentYear = date('Y');
        
        $latestRadicado = Radicado::where('nit_empresa', $nitEmpresa)
            ->where('num_radicado', 'like', 'INT-' . $currentYear . '-%')
            ->lockForUpdate()
            ->orderBy('num_radicado', 'desc')
            ->first();

        $newNumber = $latestRadicado ? intval(substr($latestRadicado->num_radicado, -5)) + 1 : 1;
        return 'INT-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    private function insertRecibidoRecord($validated, $datosRemitente, $idRadicado, $rutaArchivo, $folios, $nitEmpresa)
    {
        return DB::table('recibido')->insertGetId([
            'num_radicado_int'   => $idRadicado,
            'num_radicado_ext'   => $datosRemitente['radicado_ext'],
            'fecha_hora_recib'   => now(),
            'nom_institucion'    => $datosRemitente['nom_institucion'],
            'nit_empresa'        => $nitEmpresa,
            'ciudad_proveniente' => $validated['ciudad_proveniente'],
            'asunto'             => $validated['asunto'],
            'id_tipo'            => $validated['id_tipo'],
            'id_estado_rec'      => 12, // Inicial
            'folio'              => $folios,
            'observaciones'      => "{$datosRemitente['tipo_doc']} {$datosRemitente['doc']} - " . ($validated['observaciones'] ?? ''),
            'archivo'            => $rutaArchivo,
            'nombre_persona'     => $datosRemitente['nombre_persona'],
            'doc_persona'        => $datosRemitente['doc'],
            'correo_persona'     => $datosRemitente['correo'],
            'tel_persona'        => $datosRemitente['tel'],
        ]);
    }

    private function sendConfirmationEmail($correo, $nuevoNumRadicado)
    {
        try {
            Mail::send([], [], function ($message) use ($correo, $nuevoNumRadicado) {
                $message->to($correo)
                    ->subject('Confirmación de Registro de Correspondencia')
                    ->html("
                    <div style='font-family: Arial, Helvetica, sans-serif; background-color: #f4f6fb; padding: 40px;'>
                        <div style='max-width: 520px; margin: auto; background-color: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);'>
                            <h2 style='color: #0d121b; margin-bottom: 10px; text-align: center;'>Registro de Correspondencia Exitoso</h2>
                            <p style='color: #4c669a; font-size: 15px; text-align: center;'>Su correspondencia ha sido registrada correctamente en nuestro sistema.</p>
                            <div style='margin: 30px 0; padding: 20px; background-color: #f0f4ff; border-radius: 10px; text-align: center;'>
                                <p style='margin: 0; font-size: 14px; color: #4c669a;'>El número de radicado asignado es:</p>
                                <p style='margin: 10px 0 0; font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #00b5a3;'>$nuevoNumRadicado</p>
                            </div>
                            <p style='font-size: 14px; color: #6b7280; line-height: 1.6; text-align: center;'>
                                Con este número podrá consultar el estado de su solicitud en <a href='" . route('public.correspondencia.consultar') . "' style='color: #00b5a3; text-decoration: underline;'>nuestro sistema de consulta</a>.
                            </p>
                            <hr style='margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;'>
                            <p style='font-size: 12px; color: #9ca3af; text-align: center;'>© " . date('Y') . " Sistema de Gestión. Todos los derechos reservados.</p>
                        </div>
                    </div>");
            });
        } catch (\Exception $mailEx) {
            Log::error('Error al enviar correo de radicación: ' . $mailEx->getMessage());
        }
    }

    private function validateAndGetDocumento(Request $request)
    {
        if ($request->tipo_remitente === 'Empresa') {
            $request->validate(['nit_empresa_remitente' => 'required|string']);
            return $request->nit_empresa_remitente;
        }

        $request->validate(['numero_documento' => 'required|string']);
        return $request->numero_documento;
    }

    private function getRadicadoQuery(Request $request, $documentoBuscado)
    {
        $query = \App\Models\Recibido::with([
            'radicado', 
            'tipo', 
            'estado',
            'anexos',
            'detalles' => function($q) {
                $q->whereNotNull('archivo_res')
                  ->orWhereHas('anexosRespuesta');
            },
            'detalles.anexosRespuesta'
        ])
        ->whereHas('radicado', function($q) use ($request) {
            $q->where('num_radicado', $request->numero_radicado);
        })
        ->where('doc_persona', $documentoBuscado);

        if ($request->tipo_remitente === 'Empresa') {
            $query->whereNotNull('nom_institucion');
        } else {
            $query->whereNull('nom_institucion');
        }

        return $query;
    }
}
