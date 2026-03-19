<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CorrespondenciaExternaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tipo;
use App\Models\Ciudad;
use App\Models\Radicado;

class CorrespondenciaExternaController extends Controller
{
    /**
     * Muestra el formulario público para enviar correspondencia
     */
    public function create()
    {
        $tipos = Tipo::all();
        $ciudades = Ciudad::with('departamento')->orderBy('ciudad_nom')->get();
        $empresas = \App\Models\Empresa::all();

        return view('public.correspondencia.enviar', compact('tipos', 'ciudades', 'empresas'));
    }

    /**
     * Procesa el envío del formulario público
     */
    public function store(CorrespondenciaExternaRequest $request)
    {
        // 1. Obtener datos validados
        $validated = $request->validated();

        // 2. Procesamiento del archivo principal y cálculo de folios
        $rutaArchivo = null;
        // 2. Procesamiento del archivo principal
        $rutaArchivo = null;
        $folios = $validated['folio'];

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $rutaArchivo = $file->store('correspondencia', 'public');
        }
        
        // Procesar 1 solo anexo (si lo hay)
        $anexoData = null;
        $anexoFile = null;

        // Aceptar tanto 'anexos' como array o como campo único
        if ($request->hasFile('anexos')) {
            $archivosAnexos = $request->file('anexos');
            // Si viene como array tomamos el primero, si viene como archivo único lo usamos directamente
            $anexoFile = is_array($archivosAnexos) ? ($archivosAnexos[0] ?? null) : $archivosAnexos;
        }

        if ($anexoFile && $anexoFile->isValid()) {
            $rutaAnexo     = $anexoFile->store('correspondencia', 'public');
            $nombreOriginal = $anexoFile->getClientOriginalName();

            $anexoData = [
                'ruta_archivo'    => $rutaAnexo,
                'nombre_original' => $nombreOriginal,
            ];
        }

        // Definir la empresa receptora (desde el formulario)
        $nitEmpresa = $validated['empresa_destino'];
        
        // Empleado de recepción: admin (rol=2) de la empresa destino
        $empleadoRecepcion = \App\Models\Empleado::where('nit_empresa', $nitEmpresa)
            ->where('emple_rol', 2)
            ->where('emple_estado', 1)
            ->first();
        
        // Si no hay admin activo, buscamos cualquier empleado activo de la empresa
        if (!$empleadoRecepcion) {
            $empleadoRecepcion = \App\Models\Empleado::where('nit_empresa', $nitEmpresa)
                ->where('emple_estado', 1)
                ->first();
        }
        
        $docDestinatario = $empleadoRecepcion ? $empleadoRecepcion->emple_doc : null;

        // Determinar datos del remitente
        $tipoRemitente = $validated['tipo_remitente'];
        if ($tipoRemitente === 'Empresa') {
            $docPersona     = $validated['nit_empresa_remitente'];
            $nombrePersona  = $validated['nombre_empresa'];
            $correoPersona  = $validated['correo_empresa'];
            $telPersona     = $validated['tel_empresa'] ?? null;
            $radicadoEmpresa = $validated['radicado_empresa']; // Ahora obligatorio
            $tipoDoc        = 'NIT';
        } else {
            $docPersona     = $validated['numero_documento'];
            $nombrePersona  = $validated['nombre_persona'];
            $correoPersona  = $validated['correo_persona'];
            $telPersona     = $validated['tel_persona'] ?? null;
            $radicadoEmpresa = null;
            $tipoDoc        = $validated['tipo_documento'];
        }

        DB::beginTransaction();

        try {
            // 3. Generación del Radicado Seguro (INT-AÑO-NUMERO)
            $currentYear = date('Y');
            
            $latestRadicado = Radicado::where('nit_empresa', $nitEmpresa)
                ->where('num_radicado', 'like', 'INT-' . $currentYear . '-%')
                ->lockForUpdate()
                ->orderBy('num_radicado', 'desc')
                ->first();

            if ($latestRadicado) {
                $lastNumber = intval(substr($latestRadicado->num_radicado, -5));
                $newNumber  = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $nuevoNumRadicado = 'INT-' . $currentYear . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

            $radicado = new Radicado();
            $radicado->num_radicado = $nuevoNumRadicado;
            $radicado->nit_empresa  = $nitEmpresa;
            $radicado->save();

            // 4. Inserción en tabla Recibido
            $idRecibido = DB::table('recibido')->insertGetId([
                'num_radicado_int'   => $radicado->id_radicado,
                'num_radicado_ext'   => $radicadoEmpresa, // radicado externo (obligatorio si es Empresa)
                'fecha_hora_recib'   => now(),
                'nom_institucion'    => $tipoRemitente === 'Empresa' ? $nombrePersona : null,
                'nit_empresa'        => $nitEmpresa,
                'ciudad_proveniente' => $validated['ciudad_proveniente'],
                'asunto'             => $validated['asunto'],
                'id_tipo'            => $validated['id_tipo'],
                'id_estado_rec'      => 12, // Estado 12 = Enviado (Inicial para registro público)
                'folio'              => $folios,
                'observaciones'      => "{$tipoDoc} {$docPersona} - " . ($validated['observaciones'] ?? ''),
                'archivo'            => $rutaArchivo,
                'nombre_persona'     => $tipoRemitente === 'Persona' ? $nombrePersona : null,
                'doc_persona'        => $docPersona,
                'correo_persona'     => $correoPersona,
                'tel_persona'        => $telPersona,
            ]);
            
            // 5. Insertar el anexo en anexo_recibido (si existe)
            if ($anexoData) {
                DB::table('anexo_recibido')->insert([
                    'id_recibido'     => $idRecibido,
                    'ruta_archivo'    => $anexoData['ruta_archivo'],
                    'nombre_original' => $anexoData['nombre_original'],
                ]);
            }

            // 6. Trazabilidad
            if ($docDestinatario) {
                DB::table('detalle_recibido')->insert([
                    'det_id_recibido'  => $idRecibido,
                    'det_doc_empleado' => $docDestinatario,
                    'fecha_re'         => now(),
                    'id_estado_rec'    => 7,
                    'observaciones'    => 'Documento recibido desde formulario externo'
                ]);
            }
            

            DB::commit();

            // 7. Enviar correo de confirmación al remitente
            try {
                \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($correoPersona, $nuevoNumRadicado) {
                    $message->to($correoPersona)
                        ->subject('Confirmación de Registro de Correspondencia')
                        ->html("
                        <div style='font-family: Arial, Helvetica, sans-serif; background-color: #f4f6fb; padding: 40px;'>
                            <div style='max-width: 520px; margin: auto; background-color: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);'>
                                <h2 style='color: #0d121b; margin-bottom: 10px; text-align: center;'>Registro de Correspondencia Exitoso</h2>
                                <p style='color: #4c669a; font-size: 15px; text-align: center;'>Su correspondencia ha sido registrada correctamente en nuestro sistema.</p>
                                <div style='margin: 30px 0; padding: 20px; background-color: #f0f4ff; border-radius: 10px; text-align: center;'>
                                    <p style='margin: 0; font-size: 14px; color: #4c669a;'>El número de radicado asignado es:</p>
                                    <p style='margin: 10px 0 0; font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #135bec;'>$nuevoNumRadicado</p>
                                </div>
                                <p style='font-size: 14px; color: #6b7280; line-height: 1.6; text-align: center;'>
                                    Con este número podrá consultar el estado de su solicitud en <a href='" . route('public.correspondencia.consultar') . "' style='color: #135bec; text-decoration: underline;'>nuestro sistema de consulta</a>.
                                </p>
                                <hr style='margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;'>
                                <p style='font-size: 12px; color: #9ca3af; text-align: center;'>© " . date('Y') . " Sistema de Gestión. Todos los derechos reservados.</p>
                            </div>
                        </div>");
                });
            } catch (\Exception $mailEx) {
                Log::error('Error al enviar correo de radicación: ' . $mailEx->getMessage());
            }

            return redirect()->route('public.correspondencia.enviar')->with('success', 'Correspondencia enviada exitosamente. Su número de radicado es: ' . $radicado->num_radicado . '. Se ha enviado un correo con esta información.');

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

        if ($request->tipo_remitente === 'Empresa') {
            $request->validate(['nit_empresa_remitente' => 'required|string']);
            $documentoBuscado = $request->nit_empresa_remitente;
        } else {
            $request->validate(['numero_documento' => 'required|string']);
            $documentoBuscado = $request->numero_documento;
        }

        try {
            $query = DB::table('recibido')
                ->join('radicados', 'recibido.num_radicado_int', '=', 'radicados.id_radicado')
                ->join('tipo', 'recibido.id_tipo', '=', 'tipo.id_tipo')
                ->join('estado', 'recibido.id_estado_rec', '=', 'estado.id_estado')
                ->where('radicados.num_radicado', $request->numero_radicado)
                ->where('recibido.doc_persona', $documentoBuscado);

            // Refinar la búsqueda basándonos en cómo guardamos el registro (con o sin nom_institucion)
            if ($request->tipo_remitente === 'Empresa') {
                $query->whereNotNull('recibido.nom_institucion');
            } else {
                $query->whereNull('recibido.nom_institucion');
            }

            $resultado = $query->select(
                    'radicados.num_radicado',
                    'recibido.asunto',
                    'recibido.fecha_hora_recib',
                    'estado.estado_nomb',
                    'tipo.tipo_nombre',
                    'recibido.observaciones'
                )
                ->first();

            if (!$resultado) {
                return redirect()->back()->withInput()->withErrors(['error' => 'No se encontró correspondencia con los datos proporcionados. Verifique el radicado y el documento.']);
            }

            return view('public.correspondencia.consultar', compact('resultado'));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error consultando correspondencia: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error al realizar la consulta: ' . $e->getMessage()]);
        }
    }
}
