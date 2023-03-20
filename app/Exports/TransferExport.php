<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TransferExport implements FromView, WithEvents
{
    public $data;
    public $transfer;

    public function __construct($data = "", $transfer)
    {
        $this->data = $data;
        $this->transfer = $transfer;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // ... HERE YOU CAN DO ANY FORMATTING
                $event->sheet->getRowDimension('1')->setRowHeight(33);
                $event->sheet->getColumnDimension('A')->setWidth(5.86);
                $event->sheet->getColumnDimension('B')->setWidth(47.29);
                $event->sheet->getColumnDimension('E')->setWidth(11.57);
                $event->sheet->getColumnDimension('E')->setWidth(11.57);
                $event->sheet->getColumnDimension('F')->setWidth(11.57);
                $event->sheet->getColumnDimension('G')->setWidth(11.57);

                //font chữ time new roman
                $font = [
                    'font' => array(
                        'name' => 'Times New Roman',
                        'size' => 12
                    ),               
                ];
                $event->sheet->getDelegate()->getStyle('A1:G100')->applyFromArray($font);

                $A1 = [
                    'font' => array(
                        'bold' => true,
                        'size' => 26
                    ),
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($A1);

                $A2710131819 = [
                    'font' => array(
                        'bold' => true,
                        'size' => 12
                    ),
                ];
                $event->sheet->getDelegate()->getStyle('A2')->applyFromArray($A2710131819);
                $event->sheet->getDelegate()->getStyle('A7')->applyFromArray($A2710131819);
                $event->sheet->getDelegate()->getStyle('A10')->applyFromArray($A2710131819);
                $event->sheet->getDelegate()->getStyle('A13')->applyFromArray($A2710131819);
                $event->sheet->getDelegate()->getStyle('A18')->applyFromArray($A2710131819);
                $event->sheet->getDelegate()->getStyle('A19')->applyFromArray($A2710131819);

                $event->sheet->getDelegate()->getStyle('A3:G3')->getAlignment()->setWrapText(true);
                $event->sheet->getRowDimension('3')->setRowHeight(32);

                $A5 = [
                    'font' => array(
                        'bold' => true,
                        'size' => 18
                    ),
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A5')->applyFromArray($A5);

                $A13 = [
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
                $event->sheet->getDelegate()->getStyle('A13:G13')->applyFromArray($A13)->getAlignment()->setWrapText(true);

                $boder = [
                    'fill' => array(
                        'color' => ['arbg' => 'E0F2F7']
                    ),
                    'borders' => [
                        'inside' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'left' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ]
                ];
                $count = $this->transfer->products->count() + 16;
                $table = 'A13:'.'G'.$count;
                $event->sheet->getDelegate()->getStyle($table)->applyFromArray($boder)->getAlignment()->setWrapText(true);
            },
        ];
    }

    public function view(): View
    {
        return view('product-manage.transfer.export', [
            'transfers' => $this->data,
            'transfer' => $this->transfer,
        ]);
    }
}
