<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class CorrespondenciaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $correspondencias;

    public function __construct(Collection $correspondencias)
    {
        $this->correspondencias = $correspondencias;
    }

    public function collection()
    {
        return $this->correspondencias;
    }

    public function headings(): array
    {
        return [
            'Radicado EXT',
            'Radicado INT',
            'Institución / Origen',
            'Sede / Ciudad',
            'Asunto',
            'Fecha Ingreso',
            'Destinatario',
            'Documento Dest.',
            'Folios',
            'Anexos',
            'Estado',
        ];
    }

    public function map($cor): array
    {
        return [
            $cor->num_radicado_ext ?? 'N/A',
            $cor->num_radicado_int,
            $cor->nom_institucion,
            $cor->ciudad->ciudad_nom ?? $cor->ciudad_proveniente,
            $cor->asunto,
            Carbon::parse($cor->fecha_hora_recib)->format('d/m/Y H:i'),
            trim(($cor->dirigidoA->emple_nombres ?? 'N/A') . ' ' . ($cor->dirigidoA->emple_apellidos ?? '')),
            $cor->doc_quien_dirige,
            $cor->folio,
            $cor->anexo ?? 'Ninguno',
            $cor->estado->estado_nomb ?? 'Desconocido',
        ];
    }
}
