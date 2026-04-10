<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::beginTransaction();
    // Try to insert a detalle_recibido with a likely non-existent employee ID
    $id = DB::table('detalle_recibido')->insertGetId([
        'det_id_recibido' => 1, // Assuming id 1 exists
        'det_doc_empleado' => '999999999',
        'fecha_re' => now(),
        'id_estado_rec' => 9,
        'observaciones' => 'Testing FK'
    ]);
    echo "Success! ID: $id\n";
    DB::rollBack();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
