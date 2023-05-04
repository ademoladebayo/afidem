<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class ExportStaffList implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings
{
    use Exportable;
    public $request;
    public $row_lenght;


    public function collection()
    {
        $data =  DB::table('teacher')
            ->select('teacher.teacher_id', DB::raw('CONCAT(teacher.title," ",teacher.first_name, " ", teacher.last_name) as teacher'), 'teacher.gender', 'teacher.profile_status','teacher.phone')
            ->get();

        $this->row_lenght = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return ['STAFF ID', 'FULLNAME', 'GENDER', 'STATUS', 'PHONE'];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cell_range = [1, 1, 5, $this->row_lenght];
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle($cell_range)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 15,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle($cell_range)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
        ];
    }
}
