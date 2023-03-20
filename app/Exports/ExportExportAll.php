<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportExportAll implements FromView, WithEvents
{
    use Exportable;
    public $exports_all;

    public function __construct($exports_all = "")
    {
        $this->exports_all = $exports_all;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getColumnDimension('A')->setWidth(13.29);
                $event->sheet->getColumnDimension('B')->setWidth(50);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(12.70);
                $event->sheet->getColumnDimension('E')->setWidth(15.70);
                $event->sheet->getColumnDimension('F')->setWidth(19.29);
                $event->sheet->getColumnDimension('G')->setWidth(12);
                $event->sheet->getColumnDimension('H')->setWidth(12);
                $event->sheet->getColumnDimension('I')->setWidth(36.75);
                $event->sheet->getColumnDimension('J')->setWidth(75);
                $event->sheet->getColumnDimension('L')->setWidth(10.30);
                $event->sheet->getColumnDimension('M')->setWidth(19.15);
                $event->sheet->getColumnDimension('N')->setWidth(14.86);
                $event->sheet->getColumnDimension('O')->setWidth(35.57);

                $boder = [
                    'font' => array(
                        'bold' => true,
                        'size' => 12
                    ),
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],                 
                ];
                $event->sheet->getDelegate()->getStyle('A3:O3')->applyFromArray($boder);
            }
        ];
    }

    public function view(): View
    {
        return view('product-manage.export.exportall', [
            'exports_all' => $this->exports_all
        ]);
    }
}
