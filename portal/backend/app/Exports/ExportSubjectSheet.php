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

class ExportSubjectSheet implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings
{
    use Exportable;
    public $request;
    public $row_lenght;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request;

        $data =  DB::table('subject_registration')
            ->where("subject_id", $request->subject_id)
            ->where("session", $request->session)
            ->where("term", $request->term)
            ->join('student', 'subject_registration.student_id', '=', 'student.id')
            ->join('subject', 'subject_registration.subject_id', '=', 'subject.id')
            ->join('class', 'subject_registration.class_id', '=', 'class.id')
            ->select(DB::raw('CONCAT(subject_registration.subject_id, "-", student.id) as reg_id'), 'subject.subject_name', 'class.class_name', DB::raw('CONCAT(student.first_name, " ", student.last_name) as student'), 'subject_registration.first_ca', 'subject_registration.second_ca', 'subject_registration.examination')
            ->get();

        $this->row_lenght = count($data) + 1;

        return $data;
    }

    public function headings(): array
    {
        return ['REG ID', 'SUBJECT', 'CLASS', 'STUDENT', 'TEST 1', 'TEST 2', 'EXAMINATION'];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cell_range = [1, 1, 7, $this->row_lenght];
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
