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
            'Origen',
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
            $cor->origen,
            $cor->num_radicado_ext ?? 'N/A',
            $cor->num_radicado_int,
            $cor->nom_institucion,
            $cor->ciudad,
            $cor->asunto,
            Carbon::parse($cor->fecha)->format('d/m/Y H:i'),
            $cor->destinatario_nombre,
            $cor->doc_destinatario,
            $cor->folio,
            $cor->digital_anexos . ' digital, ' . ($cor->anexo ?? 'Ninguno físico'),
            $cor->estado_nomb,
        ];
    }
}
