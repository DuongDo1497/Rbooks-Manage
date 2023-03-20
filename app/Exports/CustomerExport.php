<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CustomerExport implements FromView, WithEvents
{
    public $data;

    public function __construct($data = "")
    {
        $this->data = $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getColumnDimension('B')->setWidth(30);
                $event->sheet->getColumnDimension('C')->setWidth(14);
                $event->sheet->getColumnDimension('D')->setWidth(14);
                $event->sheet->getColumnDimension('E')->setWidth(40);
                $event->sheet->getColumnDimension('F')->setWidth(100);
                $event->sheet->getColumnDimension('G')->setWidth(40);

                $boder = [
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
                $center = [
                    'alignment' => [
                        'vertical' => 'center'
                    ],                 
                ];
                $event->sheet->getDelegate()->getStyle('A3:G3')->applyFromArray($boder);
                $event->sheet->getDelegate()->getStyle('A3:G500')->applyFromArray($center)->getAlignment()->setWrapText(true);
            }
        ];
    }

    public function view(): View
    {
        return view('product-manage.customer.export', [
            'customers' => $this->data
        ]);
    }
}
