<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// We will simulate the request logic directly to avoid CSRF and route complexities in CLI ad-hoc
use App\Models\Tipo;
use App\Models\Ciudad;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

echo "Starting verification...\n";

// Ensure a PDF exists for testing
$testPdfPath = __DIR__ . '/public/test_adjunto.pdf';
if (!file_exists($testPdfPath)) {
    // We just create a dummy txt and rename to pdf for testing the upload validation, 
    // but pdfparser will fail if it's not a real PDF. 
    // Let's create a minimal valid PDF.
    $pdfContent = "%PDF-1.4\n%âãÏÓ\n1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n5 0 obj\n<< /Length 44 >>\nstream\nBT\n/F1 24 Tf\n100 700 Td\n(Hello World) Tj\nET\nendstream\nendobj\nxref\n0 6\n0000000000 65535 f \n0000000015 00000 n \n0000000064 00000 n \n0000000121 00000 n \n0000000257 00000 n \n0000000345 00000 n \ntrailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n440\n%%EOF";
    file_put_contents($testPdfPath, $pdfContent);
}

// Emulate a File Upload
$file = new \Illuminate\Http\UploadedFile($testPdfPath, 'test_adjunto.pdf', 'application/pdf', null, true);

// Fetch dependencies
$tipo = Tipo::first();
$ciudad = Ciudad::first();
$empresa = Empresa::first();

if (!$tipo || !$ciudad || !$empresa) {
    die("Missing master data. Run seeders first.\n");
}

echo "Master data found: Tipo={$tipo->id_tipo}, Ciudad={$ciudad->ciudad_cod_post}, Empresa={$empresa->nit_empresa}\n";

// 1. Simulate Persona Request
echo "\n--- SIMULATING PERSONA UPLOAD ---\n";
$requestPersona = \Illuminate\Http\Request::create('/correspondencia/enviar', 'POST', [
    'tipo_remitente' => 'Persona',
    'empresa_destino' => $empresa->nit_empresa,
    'tipo_documento' => 'CC',
    'numero_documento' => '123456789',
    'nombre_persona' => 'Juan Perez Test',
    'correo_persona' => 'juan@test.com',
    'tel_persona' => '3001234567',
    'ciudad_proveniente' => $ciudad->ciudad_cod_post,
    'id_tipo' => $tipo->id_tipo,
    'asunto' => 'Test asunto persona',
], [], ['archivo' => $file]);

// Bypass validation middleware by constructing the controller directly 
// (for quick verification, or we can just run the logic block)
$controller = app(\App\Http\Controllers\Public\CorrespondenciaExternaController::class);

// Inject real request into a FormRequest to fake validation
$formRequestPersona = \App\Http\Requests\CorrespondenciaExternaRequest::createFrom($requestPersona);
$formRequestPersona->setContainer($app);
// We skip full form request validation lifecycle in direct call and manually validate
$validator = validator($formRequestPersona->all(), $formRequestPersona->rules());
if ($validator->fails()) {
    echo "Persona Validation Failed:\n";
    print_r($validator->errors()->all());
} else {
    echo "Persona Validation Passed.\n";
    $formRequestPersona->setValidator($validator);
    $controller->store($formRequestPersona);
    $lastRecibido = DB::table('recibido')->orderBy('id_recibido', 'desc')->first();
    echo "Persona Inserted! Radicado: " . (\App\Models\Radicado::find($lastRecibido->num_radicado_int)->num_radicado) . " | Folios: {$lastRecibido->folio} | Tipo: {$lastRecibido->tipo_remitente}\n";
}


// 2. Simulate Empresa Request
echo "\n--- SIMULATING EMPRESA UPLOAD ---\n";
$requestEmpresa = \Illuminate\Http\Request::create('/correspondencia/enviar', 'POST', [
    'tipo_remitente' => 'Empresa',
    'empresa_destino' => $empresa->nit_empresa,
    'nit_empresa_remitente' => '900123456',
    'nombre_empresa' => 'Empresa Test SAS',
    'radicado_empresa' => 'RAD-EXT-99',
    'correo_empresa' => 'contacto@empresatest.com',
    'tel_empresa' => '6011234567',
    'ciudad_proveniente' => $ciudad->ciudad_cod_post,
    'id_tipo' => $tipo->id_tipo,
    'asunto' => 'Test asunto empresa',
], [], ['archivo' => $file]);

$formRequestEmpresa = \App\Http\Requests\CorrespondenciaExternaRequest::createFrom($requestEmpresa);
$formRequestEmpresa->setContainer($app);
$validator2 = validator($formRequestEmpresa->all(), $formRequestEmpresa->rules());
if ($validator2->fails()) {
    echo "Empresa Validation Failed:\n";
    print_r($validator2->errors()->all());
} else {
    echo "Empresa Validation Passed.\n";
    $formRequestEmpresa->setValidator($validator2);
    $controller->store($formRequestEmpresa);
    $lastRecibido = DB::table('recibido')->orderBy('id_recibido', 'desc')->first();
    echo "Empresa Inserted! Radicado: " . (\App\Models\Radicado::find($lastRecibido->num_radicado_int)->num_radicado) . " | Folios: {$lastRecibido->folio} | Tipo: {$lastRecibido->tipo_remitente} | Radicado E.: {$lastRecibido->radicado_empresa}\n";
}

echo "\nVerification script completed.\n";
