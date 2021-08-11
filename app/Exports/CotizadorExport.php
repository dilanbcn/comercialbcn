<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CotizadorExport implements WithColumnWidths, FromView, WithStyles
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('pages.cotizador.cotizador-export', $this->data);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 60,
            'B' => 10,
            'C' => 15,
            'D' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            // 1    => ['font' => ['bold' => true]],

            // 1  => ['font' => ['color' => ['rgb' => 'FFFFFF']], ['fill' => ['color' => ['rgb' => '00B050']]]],

            
            'A1' => [
                //Set border Style
                'borders' => [ 
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],

                ],
                //Set font style
                'font' => [
                    // 'name'      =>  'Calibri',
                    // 'size'      =>  15,
                    'bold'      =>  true,
                    'color' => ['argb' => '000000'],
                ],

                //Set background style
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F2F2F2']           
                ],
            ],
            'B1:D1' => [
                //Set border Style
                'borders' => [ 
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],

                //Set font style
                'font' => [
                    // 'name'      =>  'Calibri',
                    // 'size'      =>  15,
                    'bold'      =>  true,
                    'color' => ['argb' => 'FFFFFF'],
                ],

                //Set background style
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '00B050']           
                ],

            ],
            $this->data['celdas'] => [
                //Set border Style
                'borders' => [ 
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],

            $this->data['celdas_totales'] => [
                //Set font style
                'font' => [
                    'bold'      =>  true,
                    'color' => ['argb' => '000000'],
                ],
                //Set background style
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F2F2F2']           
                ],
            ],
            
        ];
    }
}
