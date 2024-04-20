<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row)
        {
            Question::create([
                'exam_id'   => (int) $row['exam_id'],
                'question'  => $row['question'],
                'option_1'  => $row['option_1'],
                'option_2'  => $row['option_2'],
                'option_3'  => $row['option_3'],
                'option_4'  => $row['option_4'],
                'answer'    => $row['answer'],
                'tipe'      => $row['tipe'],
            ]);
        }
    }
}
