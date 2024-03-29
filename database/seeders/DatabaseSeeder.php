<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserTableSeeder::class,
        ]);

        Lesson::create([
            'title'      => 'Informatika',
        ]);

        Classroom::create([
            'title'      => 'VII D',
        ]);

        Exam::create([
            'title'      => 'Test Ujian',
            'lesson_id'      => 1,
            'classroom_id'      => 1,
            'duration'      => 5,
            'description'      => 'Deskripsi Ujian',
            'random_question'      => 'Y',
            'show_answer'      => 'Y',
        ]);
    }
}
