<?php

namespace App\Livewire;

use App\Mail\CourseCompletedMail;
use App\Models\CourseCompletion;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class VideoPlayer extends Component
{
    public $lesson;

    public function mount($lesson)
    {
        $this->lesson = $lesson;
    }

    public function trackProgress($seconds)
    {
        if (Auth::check()) {
            LessonProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'lesson_id' => $this->lesson->id,
                ],
                [
                    'watch_seconds' => $seconds,
                    'started_at' => now(),
                ]
            );
        }

        return $this->skipRender();
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

    public function goToNextLesson()
    {
        $next = $this->getNextLesson();
        if ($next) {
            return redirect()->route('lessons.show', ['course' => $next->course, 'lesson' => $next]);
        }
    }

    public function getNextLesson()
    {
        return $this->lesson->course->lessons()
            ->where('order', '>', $this->lesson->order)
            ->orderBy('order')
            ->first();
    }

    public function render()
    {
        $progress = 0;
        if (Auth::check()) {
            $progress = (int) (LessonProgress::where('user_id', Auth::id())
                ->where('lesson_id', $this->lesson->id)
                ->value('watch_seconds') ?? 0);
        }

        return view('livewire.video-player', ['progress' => $progress]);
    }
}
