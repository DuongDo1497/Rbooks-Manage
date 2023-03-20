<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KPIExport implements FromView, WithEvents
{
    use Exportable;
    
    protected $kpis;
    protected $employeename;
    protected $positionname;
    protected $departmentname;

    public function __construct($kpis, $employeename, $positionname, $departmentname)
    {
        $this->kpis = $kpis;
        $this->employeename = $employeename;
        $this->positionname = $positionname;
        $this->departmentname = $departmentname;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->setBreak( 'A', 'L');
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(25);
                $event->sheet->getColumnDimension('C')->setWidth(13);
                $event->sheet->getColumnDimension('D')->setWidth(15);
                $event->sheet->getColumnDimension('E')->setWidth(40);
                $event->sheet->getColumnDimension('F')->setWidth(15);
                $event->sheet->getColumnDimension('G')->setWidth(15);
                $event->sheet->getColumnDimension('H')->setWidth(25);
                $event->sheet->getColumnDimension('I')->setWidth(28);
                $event->sheet->getColumnDimension('J')->setWidth(70);

                $center = [
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A3:A200')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('B3:B200')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('C3:C200')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('D3:D200')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('F3:F200')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('G3:G200')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('H3:H200')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('I3:I200')->applyFromArray($center);

                $centerleft = [
                    'alignment' => [
                        'vertical' => 'center'
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('E3:E200')->applyFromArray($centerleft)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('J3:J200')->applyFromArray($centerleft);

                $styleArray = [
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
                    ],
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

                $count = count($this->kpis) + 2;
                $tablejobs = 'J3:'.'J'.$count;

                $event->sheet->getDelegate()->getStyle('A1:J1')->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A2:J2')->applyFromArray($styleArray)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle($tablejobs)->getAlignment()->setWrapText(true);

                $border = [
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
                    ],
                ];
                $count = count($this->kpis) + 2;
                $tableprojects = 'A3:' . 'J' . $count;
                $event->sheet->getDelegate()->getStyle($tableprojects)->applyFromArray($border);
            }
        ];
    }

    public function view(): View
    {
        return view('company-manage.kpi.export', ['kpis' => $this->kpis, 'employeename' => $this->employeename, 'positionname' => $this->positionname, 'departmentname' => $this->departmentname]);
    }
}