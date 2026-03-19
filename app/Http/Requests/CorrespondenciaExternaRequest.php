<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorrespondenciaExternaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Acceso público autorizado
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'tipo_remitente'     => 'required|in:Persona,Empresa',
            'empresa_destino'    => 'required|exists:empresa,nit_empresa',
            'ciudad_proveniente' => 'required|exists:ciudad,ciudad_cod_post',
            'id_tipo'            => 'required|exists:tipo,id_tipo',
            'asunto'             => 'required|string|max:100',
            'observaciones'      => 'nullable|string|max:250',
            'archivo'            => 'required|file|mimes:pdf|max:5120',  // 5MB máximo, solo PDF
            'anexos'             => 'nullable|array|max:1',              // Máximo 1 anexo
            'anexos.*'           => 'file|mimes:pdf|max:25600',          // Solo PDF, 25MB máximo
        ];

        if ($this->input('tipo_remitente') === 'Empresa') {
            $rules = array_merge($rules, [
                'nit_empresa_remitente' => 'required|string|max:20',
                'nombre_empresa'        => 'required|string|max:100',
                'correo_empresa'        => 'required|email|max:255',
                'tel_empresa'           => 'nullable|string|max:25',
                'radicado_empresa'      => 'required|string|max:100', // Obligatorio para Empresas
            ]);
        } else {
            $rules = array_merge($rules, [
                'tipo_documento'     => 'required|in:CC,CE,NIT,PASAPORTE,OTRO',
                'numero_documento'   => 'required|string|max:20',
                'nombre_persona'     => 'required|string|max:100',
                'correo_persona'     => 'required|email|max:255',
                'tel_persona'        => 'nullable|string|max:25',
            ]);
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'tipo_remitente.required'     => 'Debe especificar el tipo de remitente.',
            'empresa_destino.required'    => 'Debe seleccionar la empresa destino.',
            'empresa_destino.exists'      => 'La empresa destino seleccionada no es válida.',
            'tipo_documento.required'     => 'El tipo de documento es obligatorio.',
            'tipo_documento.in'           => 'Seleccione un tipo de documento válido.',
            'numero_documento.required'   => 'El número de documento es obligatorio.',
            'nombre_persona.required'     => 'El nombre completo es obligatorio.',
            'correo_persona.required'     => 'El correo electrónico es obligatorio.',
            'correo_persona.email'        => 'El correo electrónico debe tener un formato válido.',
            
            'nit_empresa_remitente.required' => 'El NIT de la empresa es obligatorio.',
            'nombre_empresa.required'        => 'El nombre de la empresa es obligatorio.',
            'correo_empresa.required'        => 'El correo electrónico de la empresa es obligatorio.',
            'correo_empresa.email'           => 'El correo electrónico debe tener un formato válido.',
            'radicado_empresa.required'      => 'El número de radicado externo de la empresa es obligatorio.',
            
            'ciudad_proveniente.required' => 'Debe seleccionar una ciudad válida.',
            'ciudad_proveniente.exists'   => 'La ciudad seleccionada no es válida.',
            'id_tipo.required'            => 'Debe seleccionar el tipo de correspondencia.',
            'id_tipo.exists'              => 'El tipo de correspondencia seleccionado no es válido.',
            'asunto.required'             => 'El asunto es obligatorio.',
            'archivo.required'            => 'Debe adjuntar un archivo principal.',
            'archivo.mimes'               => 'El archivo principal debe ser un PDF.',
            'archivo.max'                 => 'El archivo principal no debe pesar más de 5MB.',
            
            'anexos.array'                => 'El formato de los anexos es inválido.',
            'anexos.max'                  => 'Solo puede adjuntar máximo 1 anexo.',
            'anexos.*.file'               => 'El anexo no es un archivo válido.',
            'anexos.*.mimes'              => 'El anexo debe estar en formato PDF.',
            'anexos.*.max'                => 'El anexo no debe pesar más de 25MB.',
        ];
    }
}
