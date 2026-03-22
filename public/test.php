<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$empDoc = '1005912001';

$misEnviosIds = \App\Models\Envio::where('doc_quien_envia', $empDoc)->pluck('id_envio');
echo "Mis Envios: " . json_encode($misEnviosIds) . "\n";

$detalles = DB::table('detalle_envio')
    ->whereIn('id_envio', $misEnviosIds)
    ->orderBy('id_detalle', 'asc')
    ->get(['id_detalle', 'id_envio', 'id_quien_envie', 'id_quien_recibe', 'id_estado_rec']);

foreach ($detalles as $d) {
    echo "ID: {$d->id_detalle} | Envio: {$d->id_envio} | Envia: {$d->id_quien_envie} | Recibe: {$d->id_quien_recibe} | Estado: {$d->id_estado_rec}\n";
}

$estados = DB::table('estado_respuesta')->get(['id_estado_rec', 'estado_nomb']);
foreach ($estados as $e) {
    echo "Estado: {$e->id_estado_rec} - {$e->estado_nomb}\n";
}
