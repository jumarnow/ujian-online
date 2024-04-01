<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QuestionsImport;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Classroom;
use App\Models\ExamGroup;
use App\Models\Question;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //get exams
        $exams = Exam::when(request()->q, function($exams) {
            $exams = $exams->where('title', 'like', '%'. request()->q . '%');
        })->with('lesson', 'classroom', 'questions')->latest()->paginate(5);

        //append query string to pagination links
        $exams->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Exams/Index', [
            'exams' => $exams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //get lessons
        $lessons = Lesson::all();

        //get classrooms
        $classrooms = Classroom::all();

        //render with inertia
        return inertia('Admin/Exams/Create', [
            'lessons' => $lessons,
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //validate request
        $request->validate([
            'title'             => 'required',
            'lesson_id'         => 'required|integer',
            'classroom_id'      => 'required|integer',
            'duration'          => 'required|integer',
            'description'       => 'required',
            'random_question'   => 'required',
            'random_answer'     => 'required',
            'show_answer'       => 'required',
        ]);

        //create exam
        Exam::create([
            'title'             => $request->title,
            'lesson_id'         => $request->lesson_id,
            'classroom_id'      => $request->classroom_id,
            'duration'          => $request->duration,
            'description'       => $request->description,
            'random_question'   => $request->random_question,
            'random_answer'     => $request->random_answer,
            'show_answer'       => $request->show_answer,
        ]);

        //redirect
        return redirect()->route('admin.exams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //get exam
        $exam = Exam::with('lesson', 'classroom')->findOrFail($id);

        //get relation questions with pagination
        $exam->setRelation('questions', $exam->questions()->paginate(5));

        //render with inertia
        return inertia('Admin/Exams/Show', [
            'exam' => $exam,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //get exam
        $exam = Exam::findOrFail($id);

        //get lessons
        $lessons = Lesson::all();

        //get classrooms
        $classrooms = Classroom::all();

        //render with inertia
        return inertia('Admin/Exams/Edit', [
            'exam' => $exam,
            'lessons' => $lessons,
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        //
        //validate request
        $request->validate([
            'title'             => 'required',
            'lesson_id'         => 'required|integer',
            'classroom_id'      => 'required|integer',
            'duration'          => 'required|integer',
            'description'       => 'required',
            'random_question'   => 'required',
            'random_answer'     => 'required',
            'show_answer'       => 'required',
        ]);

        //update exam
        $exam->update([
            'title'             => $request->title,
            'lesson_id'         => $request->lesson_id,
            'classroom_id'      => $request->classroom_id,
            'duration'          => $request->duration,
            'description'       => $request->description,
            'random_question'   => $request->random_question,
            'random_answer'     => $request->random_answer,
            'show_answer'       => $request->show_answer,
        ]);

        //redirect
        return redirect()->route('admin.exams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //get exam
        $exam = Exam::findOrFail($id);

        //delete exam
        $exam->delete();

        //redirect
        return redirect()->route('admin.exams.index');
    }
    public function createQuestion(Exam $exam)
    {
        //render with inertia
        return inertia('Admin/Questions/Create', [
            'exam' => $exam,
        ]);
    }

    /**
     * storeQuestion
     *
     * @param  mixed $request
     * @param  mixed $exam
     * @return void
     */
    public function storeQuestion(Request $request, Exam $exam)
    {
        // dd($request->all());
        //validate request
        $request->validate([
            'question'          => 'required',
            'option_1'          => 'required',
            'option_2'          => 'required',
            'option_3'          => 'required',
            'option_4'          => 'required',
            'answer'            => 'required',
        ]);

        //create question
        Question::create([
            'exam_id'           => $exam->id,
            'question'          => $request->question,
            'question_img'          => $request->question_img,
            'option_1'          => $request->option_1,
            'option_1_img'          => $request->option_1_img,
            'option_2'          => $request->option_2,
            'option_2_img'          => $request->option_2_img,
            'option_3'          => $request->option_3,
            'option_3_img'          => $request->option_3_img,
            'option_4'          => $request->option_4,
            'option_4_img'          => $request->option_4_img,
            'answer'            => $request->answer,
        ]);

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }
    public function editQuestion(Exam $exam, Question $question)
    {
        //render with inertia
        return inertia('Admin/Questions/Edit', [
            'exam' => $exam,
            'question' => $question,
        ]);
    }

    /**
     * updateQuestion
     *
     * @param  mixed $request
     * @param  mixed $exam
     * @param  mixed $question
     * @return void
     */
    public function updateQuestion(Request $request, Exam $exam, Question $question)
    {
        //validate request
        $request->validate([
            'question'          => 'required',
            'option_1'          => 'required',
            'option_2'          => 'required',
            'option_3'          => 'required',
            'option_4'          => 'required',
            'answer'            => 'required',
        ]);

        //update question
        $question->update([
            'question'          => $request->question,
            'option_1'          => $request->option_1,
            'option_2'          => $request->option_2,
            'option_3'          => $request->option_3,
            'option_4'          => $request->option_4,
            'answer'            => $request->answer,
        ]);

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }

    public function destroyQuestion(Exam $exam, Question $question)
    {
        //delete question
        $question->delete();

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }

    public function import(Exam $exam)
    {
        return inertia('Admin/Questions/Import', [
            'exam' => $exam
        ]);
    }

    public function storeImport(Request $request, Exam $exam)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // import data
        Excel::import(new QuestionsImport(), $request->file('file'));

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }

    public function exams_upload_image(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        if ($request->tipe == 'question') {
            $file->move(public_path('exam_img/'.$request->exam_id.'/question'), $fileName);
        } else {
            $file->move(public_path('exam_img/'.$request->exam_id.'/option'), $fileName);
        }


        // return response()->json(['imageName' => $fileName]);
    }


}
