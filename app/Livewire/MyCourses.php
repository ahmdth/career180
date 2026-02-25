<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('My Courses')]
class MyCourses extends Component
{
    public function mount()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        $courses = Auth::user()->courses()->with('level')->get();

        return view('pages::courses.my')->with(['courses' => $courses]);
    }
}
