<?php

namespace App\Livewire;

use App\Mail\CourseCompletedMail;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Lesson')]
class LessonShow extends Component
{
    public Lesson $lesson;

    public function mount(Lesson $lesson)
    {
        $this->lesson = $lesson;

        // If not a free preview, require authentication and enrollment
        if (! $lesson->is_free_preview) {
            if (! Auth::check()) {
                return redirect()->route('login');
            }
            $enrolled = Enrollment::where([
                'user_id' => Auth::id(),
                'course_id' => $lesson->course_id,
            ])->exists();
            if (! $enrolled) {
                abort(
                    403,
                    __('You are not enrolled in this course.')
                );
            }
        }
    }

    public function getNextLesson()
    {
        return $this->lesson->course->lessons()
            ->where('order', '>', $this->lesson->order)
            ->orderBy('order')
            ->first();
    }

    public function getPreviousLesson()
    {
        return $this->lesson->course->lessons()
            ->where('order', '<', $this->lesson->order)
            ->orderByDesc('order')
            ->first();
    }

    public function markAsCompleted()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        LessonProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'lesson_id' => $this->lesson->id],
            [
                'completed_at' => now(),
                'started_at' => now(),
                '_seconds' => $this->lesson->duration_seconds,
            ]
        );

        $course = $this->lesson->course;
        $userId = Auth::id();
        $totalLessons = $course->lessons()->count();
        $completedCount = LessonProgress::whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->count();

        if ($totalLessons > 0 && $completedCount >= $totalLessons) {
            $exists = CourseCompletion::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->exists();
            if (! $exists) {
                CourseCompletion::create([
                    'user_id' => $userId,
                    'course_id' => $course->id,
                    'completed_at' => now(),
                ]);
                Mail::to(Auth::user())->queue(new CourseCompletedMail(Auth::user(), $course));
            }
        }

        session()->flash('message', 'Lesson marked as completed!');
    }

    public function isCompleted()
    {
        if (! Auth::check()) {
            return false;
        }

        return LessonProgress::where('user_id', Auth::id())
            ->where('lesson_id', $this->lesson->id)
            ->whereNotNull('completed_at')
            ->exists();
    }

    public function render()
    {
        return view('pages::lessons.show')->with([
            'lesson' => $this->lesson,
            'nextLesson' => $this->getNextLesson(),
            'previousLesson' => $this->getPreviousLesson(),
            'isCompleted' => $this->isCompleted(),
            'courseLessons' => $this->lesson->course->lessons()->orderBy('order')->get(),
        ]);
    }
}
