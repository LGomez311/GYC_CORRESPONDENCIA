<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Tipo;
use App\Models\Ciudad;
use App\Models\Empresa;

class PublicCorrespondenceFormTest extends TestCase
{
    public function test_form_validation_fails_when_empty()
    {
        $response = $this->post(route('public.correspondencia.store'), []);
        
        $response->assertSessionHasErrors([
            'tipo_remitente',
            'empresa_destino',
            'ciudad_proveniente',
            'id_tipo',
            'asunto',
            'archivo'
        ]);
        
        $response->assertStatus(302); // Redirects back
    }
    
    public function test_form_validation_fails_for_persona()
    {
        $response = $this->post(route('public.correspondencia.store'), [
            'tipo_remitente' => 'Persona',
        ]);
        
        $response->assertSessionHasErrors([
            'tipo_documento',
            'numero_documento',
            'nombre_persona',
            'correo_persona'
        ]);
    }

    public function test_form_validation_fails_for_empresa()
    {
        $response = $this->post(route('public.correspondencia.store'), [
            'tipo_remitente' => 'Empresa',
        ]);
        
        $response->assertSessionHasErrors([
            'nit_empresa_remitente',
            'nombre_empresa',
            'correo_empresa'
        ]);
    }
}
