<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductExport implements FromView, WithEvents
{
    use Exportable;
    
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // ... HERE YOU CAN DO ANY FORMATTING
                $event->sheet->getColumnDimension('A')->setWidth(5.67);
                $event->sheet->getColumnDimension('B')->setWidth(8);
                $event->sheet->getColumnDimension('C')->setWidth(84.3);
                $event->sheet->getColumnDimension('F')->setWidth(5.67);
                $event->sheet->getColumnDimension('G')->setWidth(13);
                $event->sheet->getColumnDimension('H')->setWidth(13);
                $event->sheet->getColumnDimension('I')->setWidth(13);
                $event->sheet->getColumnDimension('J')->setWidth(13);
                $event->sheet->getColumnDimension('K')->setWidth(13);
                $event->sheet->getColumnDimension('L')->setWidth(13);
                $event->sheet->getColumnDimension('M')->setWidth(13);
                $event->sheet->getColumnDimension('N')->setWidth(13);
                $event->sheet->getColumnDimension('O')->setWidth(13);
                $event->sheet->getColumnDimension('P')->setWidth(13);
                $event->sheet->getColumnDimension('Q')->setWidth(13);
                $event->sheet->getColumnDimension('R')->setWidth(15);
                $event->sheet->getColumnDimension('S')->setWidth(15);

                //font chữ time new roman
                $font = [
                    'font' => array(
                        'name' => 'Times New Roman',
                    ),               
                ];
                $event->sheet->getDelegate()->getStyle('A1:L100')->applyFromArray($font);

                $styleArray = [
                    'font' => array(
                        'bold' => true,
                        'size' => 12
                    ),
                    'fill' => array(
                        'color' => ['arbg' => 'E0F2F7'] 
                    ),
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                                    
                ];
                $event->sheet->getDelegate()->getStyle('A3:S3')->applyFromArray($styleArray);

                $boder = [
                    'font' => array(
                        'bold' => true,
                        'size' => 12
                    ),
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                    'borders' => [
                        'inside' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]                 
                ];
                $event->sheet->getDelegate()->getStyle('F2:Q2')->applyFromArray($boder);
                $event->sheet->getDelegate()->getStyle('A3:S3')->applyFromArray($boder);

                $boder = [
                    'borders' => [
                        'inside' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                        'left' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ]
                    ]
                ];
                $count = count($this->data) + 3;
                $table = 'A4:'.'S'.$count;
                $event->sheet->getDelegate()->getStyle($table)->applyFromArray($boder);
            },
        ];
    }

    public function view(): View
    {
        return view('product-manage.product.export', [
            'products' => $this->data
        ]);
    }
}