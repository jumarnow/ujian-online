<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('admin')->group(function() {
    Route::group(['middleware' => ['auth']], function () {

        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');
        Route::resource('/lessons', \App\Http\Controllers\Admin\LessonController::class, ['as' => 'admin']);
        Route::resource('/classrooms', \App\Http\Controllers\Admin\ClassroomController::class, ['as' => 'admin']);
        Route::get('/students_import', [\App\Http\Controllers\Admin\StudentController::class, 'import'])->name('admin.students.import');
        Route::post('/students_import', [\App\Http\Controllers\Admin\StudentController::class, 'storeImport'])->name('admin.students.storeImport');
        Route::resource('/students', \App\Http\Controllers\Admin\StudentController::class, ['as' => 'admin']);
        Route::resource('/exams', \App\Http\Controllers\Admin\ExamController::class, ['as' => 'admin']);

        Route::get('/exams/{exam}/questions/create', [\App\Http\Controllers\Admin\ExamController::class, 'createQuestion'])->name('admin.exams.createQuestion');
        Route::post('/exams/{exam}/questions/store', [\App\Http\Controllers\Admin\ExamController::class, 'storeQuestion'])->name('admin.exams.storeQuestion');

        Route::get('/exams/{exam}/questions/{question}/edit', [\App\Http\Controllers\Admin\ExamController::class, 'editQuestion'])->name('admin.exams.editQuestion');
        Route::put('/exams/{exam}/questions/{question}/update', [\App\Http\Controllers\Admin\ExamController::class, 'updateQuestion'])->name('admin.exams.updateQuestion');

        Route::delete('/exams/{exam}/questions/{question}/destroy', [\App\Http\Controllers\Admin\ExamController::class, 'destroyQuestion'])->name('admin.exams.destroyQuestion');

        Route::get('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'import'])->name('admin.exam.questionImport');
        Route::post('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'storeImport'])->name('admin.exam.questionStoreImport');

        Route::resource('/exam_sessions', \App\Http\Controllers\Admin\ExamSessionController::class, ['as' => 'admin']);

        Route::get('/exam_sessions/{exam_session}/enrolle/create', [\App\Http\Controllers\Admin\ExamSessionController::class, 'createEnrolle'])->name('admin.exam_sessions.createEnrolle');
        Route::post('/exam_sessions/{exam_session}/enrolle/store', [\App\Http\Controllers\Admin\ExamSessionController::class, 'storeEnrolle'])->name('admin.exam_sessions.storeEnrolle');

        Route::delete('/exam_sessions/{exam_session}/enrolle/{exam_group}/destroy', [\App\Http\Controllers\Admin\ExamSessionController::class, 'destroyEnrolle'])->name('admin.exam_sessions.destroyEnrolle');

        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/filter', [\App\Http\Controllers\Admin\ReportController::class, 'filter'])->name('admin.reports.filter');
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');

    });
});


//route homepage
Route::get('/', function () {

    //cek session student
    if(auth()->guard('student')->check()) {
        return redirect()->route('student.dashboard');
    }

    //return view login
    return \Inertia\Inertia::render('Student/Login/Index');
});

//login students
Route::post('/students/login', \App\Http\Controllers\Student\LoginController::class)->name('student.login');

//prefix "student"
Route::prefix('student')->group(function() {

    //middleware "student"
    Route::group(['middleware' => 'student'], function () {

        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Student\DashboardController::class)->name('student.dashboard');
        Route::get('/exam-confirmation/{id}', [App\Http\Controllers\Student\ExamController::class, 'confirmation'])->name('student.exams.confirmation');

        Route::get('/exam-start/{id}', [App\Http\Controllers\Student\ExamController::class, 'startExam'])->name('student.exams.startExam');
        Route::get('/exam/{id}/{page}', [App\Http\Controllers\Student\ExamController::class, 'show'])->name('student.exams.show');
        Route::put('/exam-duration/update/{grade_id}', [App\Http\Controllers\Student\ExamController::class, 'updateDuration'])->name('student.exams.update_duration');
        Route::post('/exam-answer', [App\Http\Controllers\Student\ExamController::class, 'answerQuestion'])->name('student.exams.answerQuestion');
        Route::post('/exam-end', [App\Http\Controllers\Student\ExamController::class, 'endExam'])->name('student.exams.endExam');
        Route::get('/exam-result/{exam_group_id}', [App\Http\Controllers\Student\ExamController::class, 'resultExam'])->name('student.exams.resultExam');

    });

});
