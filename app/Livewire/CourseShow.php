<?php

namespace App\Livewire;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Course')]
class CourseShow extends Component
{
    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function render()
    {
        return view('pages::courses.show')
            ->with(['course' => $this->course, 'lessons' => $this->course->lessons()->orderBy('order')->get()]);
    }

    public function enroll()
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        if ($this->course->is_published === false) {
            abort(403, 'Cannot enroll in a draft course.');
        }
        $this->course->users()->attach(Auth::id());
        session()->flash('message', 'You have successfully enrolled in the course.');

        return redirect()->route('courses.show', $this->course->slug);
    }
}
