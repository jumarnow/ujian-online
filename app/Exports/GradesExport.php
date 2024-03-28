<?php

namespace App\Exports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GradesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $grades;

    public function __construct($grades) {
        $this->grades = $grades;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->grades;
    }

    public function map($grades) : array {
        return [
            $grades->exam->title,
            $grades->exam_session->title,
            $grades->student->name,
            $grades->exam->classroom->title,
            $grades->exam->lesson->title,
            $grades->grade,
        ] ;
    }

    public function headings() : array {
        return [
           'Ujian',
           'Sesi',
           'Nama Siswa',
           'Kelas',
           'Pelajaran',
           'Nilai'
        ] ;
    }
}
