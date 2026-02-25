<?php

use App\Livewire\CourseShow;
use App\Livewire\Home;
use App\Livewire\LessonShow;
use App\Livewire\MyCourses;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::redirect('/dashboard', '/')->name('dashboard');
Route::get('/courses/{course}', CourseShow::class)->name('courses.show');
Route::get('/courses/{course}/lessons/{lesson}', LessonShow::class)->name('lessons.show');
Route::get('/me', MyCourses::class)->name('courses.my');

require __DIR__.'/settings.php';
