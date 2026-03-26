<?php
$content = file_get_contents('resources/views/admin/historial_externa.blade.php');
$replacements = [
    "@extends('empleado.layouts.app')" => "@extends('admin.layouts.app')",
    "route('empleado.envios_internos')" => "route('admin.correspondencia.index')",
    "Mis Envíos\n                                Internos" => "Correspondencia",
    "Regresar a Mis Envíos" => "Regresar a Correspondencia",
    '$detalle->envio->radicado->num_radicado' => '$recibido->radicado->num_radicado',
    '$detalle->envio->asunto' => '$recibido->asunto',
    '$detalle->envio->tipoEnvio->tipo_nombre' => '$recibido->tipo->tipo_nombre',
    '$detalle->envio->folio' => '$recibido->folio',
    '$detalle->quienEnvia->emple_nombres' => '$remitenteMock->emple_nombres',
    '$detalle->quienEnvia->emple_apellidos' => '$remitenteMock->emple_apellidos',
    '$detalle->quienEnvia->area->area_nom' => '$remitenteMock->area_nom',
    '$detalle->envio->fecha' => '$recibido->fecha_hora_recib',
    '$detalle->envio->archivo' => '$recibido->archivo',
    '$detalle->envio->anexos' => '$recibido->anexos',
    '$detalle->envio->doc_quien_envia' => '$recibido->doc_quien_registra',
    '$trace->fecha_traslado' => '$trace->fecha_re',
    '$trace->quienRecibe->emple_nombres' => '$trace->empleado->emple_nombres',
    '$trace->quienRecibe->emple_doc' => '$trace->empleado->emple_doc',
    '$trace->id_quien_recibe' => '$trace->det_doc_empleado',
    '$trace->id_quien_envie' => '$trace->det_doc_empleado',
];
foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

// Special regex replacements
$content = preg_replace('/\\$destinatarios\\[\\$trace->id_quien_recibe\\]/', '$destinatarios[$trace->det_doc_empleado]', $content);
$content = preg_replace('/\\$trace->id_detalle\\s*==\\s*\\$destinatarios\\[\\$trace->det_doc_empleado\\]->last\\(\\)->id_detalle/', '$trace->id_det_recibido == $destinatarios[$trace->det_doc_empleado]->last()->id_det_recibido', $content);

file_put_contents('resources/views/admin/historial_externa.blade.php', $content);
echo "Transformation complete.\n";
