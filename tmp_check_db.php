<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$doc = '999004';
$e = DB::table('empleado')->where('emple_doc', $doc)->first();
$r = DB::table('remitente')->where('rem_doc', $doc)->first();

echo "Empleado: \n";
print_r($e);
echo "\nRemitente: \n";
print_r($r);

// Find an employee (rol 3) for the same company to use as proxy if needed
$nit = '9887978978';
$proxy = DB::table('empleado')->where('nit_empresa', $nit)->where('emple_rol', 3)->first();
echo "\nProxy Empleado (rol 3): \n";
print_r($proxy);
