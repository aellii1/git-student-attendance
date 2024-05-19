<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FingerDevicesControlller;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(['register' => true, 'reset' => false]);

Route::group(['middleware' => ['auth', 'Role'], 'roles' => ['admin']], function () {

    // track route
    Route::get('/tracks', '\App\Http\Controllers\TrackController@index')->name('tracks');
    Route::post('/tracks', '\App\Http\Controllers\TrackController@store')->name('tracks.store');
    Route::put('/tracks/{id}', '\App\Http\Controllers\TrackController@update')->name('tracks.update');
    Route::delete('/tracks/{id}', '\App\Http\Controllers\TrackController@destroy')->name('tracks.destroy');

    // section route
    Route::get('/sections', 'App\Http\Controllers\SectionController@index')->name('sections');
    Route::post('/sections', 'App\Http\Controllers\SectionController@store')->name('sections.store');
    Route::put('/sections/{id}', 'App\Http\Controllers\SectionController@update')->name('sections.update');
    Route::delete('/sections/{id}', 'App\Http\Controllers\SectionController@destroy')->name('sections.destroy');

    // student route 
    Route::get('/students', 'App\Http\Controllers\StudentController@index')->name('students');
    Route::post('/students', 'App\Http\Controllers\StudentController@store')->name('students.store');
    Route::put('/students/{id}', 'App\Http\Controllers\StudentController@update')->name('students.update');
    Route::delete('/students/{id}', 'App\Http\Controllers\StudentController@destroy')->name('students.destroy');

    // student-detail route
    Route::get('/', 'App\Http\Controllers\StudentController@studentDetail')->name('student_detail');
    Route::post('/', 'App\Http\Controllers\StudentController@studentDetailStore')->name('student.detail.store');

    // attendance-logs route
    Route::get('/student-logs', 'App\Http\Controllers\StudentController@student_logs')->name('student_logs');

    // upload photo
    Route::post('/upload-image', 'App\Http\Controllers\StudentController@uploadImage')->name('upload.image');

    // display photo
    Route::get('/student/profile/{id}', 'StudentController@showProfile')->name('student.profile');

    // admin route
    Route::get('/admin', '\App\Http\Controllers\AdminController@index')->name('admin');
    Route::get('/admin', '\App\Http\Controllers\AdminController@showDashboard')->name('admin');

});

Route::group(['middleware' => ['auth', 'Role'], 'roles' => ['faculty']], function () {

    // faculty route
    Route::get('faculty', 'App\Http\Controllers\FacultyController@index')->name('faculty');
    

});
