<?php

namespace App\Exports;

use App\Models\Plan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PlanesExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $planes;

    public function __construct()
    {
        $this->planes = Plan::orderByDesc('es_destacado')->get();
    }

    public function collection()
    {
        return $this->planes->map(function ($plan) {
            return [
                'Nombre' => $plan->nomb_plan,
                'Descripción' => is_array($plan->descripcion)
                    ? implode("\n• ", array_merge([''], $plan->descripcion))
                    : $plan->descripcion,
                'Precio' => $plan->valor,
                'Duración' => $plan->duracion ? $plan->duracion . ' días' : 'Ilimitado',
                'Destacado' => $plan->es_destacado ? '⭐ Sí' : 'No',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Descripción / Beneficios',
            'Precio',
            'Duración',
            'Destacado',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ===== ENCABEZADOS =====
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'F3F4F6'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin'],
            ],
        ]);

        // ===== FILAS =====
        $row = 2;
        foreach ($this->planes as $plan) {
            // Ajustar wrap text
            $sheet->getStyle("A{$row}:E{$row}")
                ->getAlignment()
                ->setWrapText(true)
                ->setVertical('top');

            // Bordes
            $sheet->getStyle("A{$row}:E{$row}")
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle('thin');

            // ⭐ PLAN DESTACADO
            if ($plan->es_destacado) {
                $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['rgb' => 'EEF2FF'],
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            }

            $row++;
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22, // Nombre
            'B' => 50, // Beneficios
            'C' => 16, // Precio
            'D' => 16, // Duración
            'E' => 14, // Destacado
        ];
    }
}
