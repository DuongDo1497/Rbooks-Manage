<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportExport implements FromView, WithEvents
{
    public $data;
    public $exports;

    public function __construct($data = "", $exports)
    {
        $this->data = $data;
        $this->exports = $exports;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // ... HERE YOU CAN DO ANY FORMATTING
                $event->sheet->setBreak( 'A', 'L');
                $event->sheet->getColumnDimension('A')->setWidth(5.67);
                $event->sheet->getColumnDimension('B')->setWidth(46.17);
                $event->sheet->getColumnDimension('C')->setWidth(8.83);
                $event->sheet->getColumnDimension('D')->setWidth(8.67);
                $event->sheet->getColumnDimension('E')->setWidth(12.33);
                $event->sheet->getColumnDimension('F')->setWidth(12.33);
                $event->sheet->getColumnDimension('G')->setWidth(12.33);
                $event->sheet->getRowDimension('2')->setRowHeight(43);
                $event->sheet->getRowDimension('4')->setRowHeight(32);
                $event->sheet->getRowDimension('10')->setRowHeight(32);

                $center = [
                    'font' => array(
                        'name' => 'Times New Roman',
                        'alignment' => 'center'
                    ),
                ];

                $cellRange = 'C1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont('bold')->setSize(26);

                // Apply array of styles to B2:G8 cell range
                $styleArray = [
                    'font' => array(
                        'name' => 'Times New Roman',
                        'size' => 12,
                    ),
                ];
                $event->sheet->getDelegate()->getStyle('A1:L50')->applyFromArray($styleArray);

                // Set first row to height 20
                $C1 = 'C1';
                $styleArray = [
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'color' => ['arbg' => 'E0F2F7']
                    ),
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                ];
                $left = [
                    'font' => array(
                        'bold' => true
                    ),
                ];
                $event->sheet->getDelegate()->getStyle('C1')->applyFromArray($left);
                $event->sheet->getDelegate()->getStyle('A4')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A10')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A18:H18')->applyFromArray($styleArray)->getAlignment()->setWrapText(true);

                $total = [
                    'font' => array(
                        'bold' => true
                    ),
                ];

                //$event->sheet->getDelegate()->getStyle('A22')->applyFromArray($total);
                $event->sheet->getDelegate()->getStyle('B22')->applyFromArray($total);
                $event->sheet->getDelegate()->getStyle('G22')->applyFromArray($total);

                $event->sheet->getDelegate()->getStyle('A23')->applyFromArray($total);
                $event->sheet->getDelegate()->getStyle('B23')->applyFromArray($total);
                $event->sheet->getDelegate()->getStyle('G23')->applyFromArray($total);

                $event->sheet->getDelegate()->getStyle('A24')->applyFromArray($total);
                $event->sheet->getDelegate()->getStyle('A26')->applyFromArray($total);

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

                $count = $this->exports->products->count() + 25;
                $table = 'A18:'.'H'.$count;
                $event->sheet->getDelegate()->getStyle($table)->applyFromArray($boder)->getAlignment()->setWrapText(true);

                $A6 = 'A6';
                $A1 = 'A1';
                $sty = [
                    'alignment' => [
                         'horizontal' => 'center'
                     ],
                     'font' => array(
                        'bold' => true
                    ),
                ];
                $event->sheet->getDelegate()->getStyle($A6)->getFont()->setSize(18);
                $event->sheet->getDelegate()->getStyle($A1)->getFont()->setSize(26);
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($sty);
                $event->sheet->getDelegate()->getStyle('A6')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getRowDimension($A6)->setRowHeight(30);

                $A7 = 'A7';
                $styleArray = [
                    'alignment' => [
                         'horizontal' => 'center'
                     ],
                ];
                $event->sheet->getDelegate()->getStyle($A7)->getFont()->setSize(10);
                $event->sheet->getDelegate()->getStyle('A7')->applyFromArray($styleArray);

                $event->sheet->getDelegate()->getRowDimension($C1)->setRowHeight(50);

                $A3 = 'A3';
                $styleArray = [
                    'font' => array(
                        'bold' => true
                    ),
                ];
                $event->sheet->getDelegate()->getStyle('A3')->applyFromArray($styleArray);

                // Set A1:D4 range to wrap text in cells
                //$event->sheet->getDelegate()->getStyle('A1:D4')
                    //->getAlignment()->setWrapText(true);
                },
        ];
    }
    public function view(): View
    {
        return view('product-manage.export.export', [
            'exports' => $this->data
        ]);
    }
}
