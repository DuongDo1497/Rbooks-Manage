<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderExportAll implements FromView, WithEvents
{
    use Exportable;
    
    protected $orders_all;

    public function __construct($orders_all = "")
    {
        $this->orders_all = $orders_all;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getColumnDimension('A')->setWidth(13.30);
                $event->sheet->getColumnDimension('B')->setWidth(30.45);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(12.70);
                $event->sheet->getColumnDimension('E')->setWidth(50);
                $event->sheet->getColumnDimension('F')->setWidth(110.90);
                $event->sheet->getColumnDimension('H')->setWidth(12);
                $event->sheet->getColumnDimension('I')->setWidth(36.75);

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
        return view('product-manage.order.exportall', ['orders_all' => $this->orders_all]);
    }
}