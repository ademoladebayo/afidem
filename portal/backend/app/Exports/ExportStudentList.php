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

class ExportStudentList implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings
{
    use Exportable;
    public $request;
    public $row_lenght;

    public function collection()
    {
        $request = $this->request;

        $data =  DB::table('student')
            ->join('class', 'student.class', '=', 'class.id')
            ->select('student.student_id', DB::raw('CONCAT(student.first_name, " ", student.last_name) as student'), 'class.class_name', 'student.gender', 'student.profile_status')
            ->get();

        $this->row_lenght = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return ['STUDENT ID', 'FULLNAME', 'CLASS', 'GENDER', 'STATUS'];
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
