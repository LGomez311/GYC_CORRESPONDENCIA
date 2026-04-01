<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;
echo "--- TABLA pagos ---\n";
$desc = DB::select('DESCRIBE pagos');
foreach($desc as $d) {
    echo "{$d->Field} | {$d->Type} | {$d->Null} | {$d->Key} | {$d->Default} | {$d->Extra}\n";
}
echo "--- TABLA plan ---\n";
$desc = DB::select('DESCRIBE plan');
foreach($desc as $d) {
    echo "{$d->Field} | {$d->Type} | {$d->Null} | {$d->Key} | {$d->Default} | {$d->Extra}\n";
}
