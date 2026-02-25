<?php

use App\Livewire\LessonShow;
use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->course = Course::factory()->create(['is_published' => true]);
    $this->lesson = Lesson::factory()->create([
        'course_id' => $this->course->id,
        'is_free_preview' => true,
    ]);
});

it('allows guests to access free preview lessons', function () {
    Livewire::test(LessonShow::class, ['course' => $this->course, 'lesson' => $this->lesson])
        ->assertOk();
});

it('prevents guests from accessing non-preview lessons', function () {
    $this->lesson->update([
        'is_free_preview' => false,
    ]);
    Livewire::test(LessonShow::class, ['course' => $this->course, 'lesson' => $this->lesson])
        ->assertRedirect('/login');
});

it('prevents unenrolled users from accessing non-preview lessons', function () {
    $user = User::factory()->create();
    $this->lesson->update([
        'is_free_preview' => false,
    ]);
    Livewire::actingAs($user)
        ->test(LessonShow::class, ['course' => $this->course, 'lesson' => $this->lesson])
        ->assertForbidden();
});

it('allows authenticated unenrolled users to access free-preview lessons', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(LessonShow::class, ['course' => $this->course, 'lesson' => $this->lesson])
        ->assertOk();
});

it('recording lesson completion updates lesson_progress', function () {
    $user = User::factory()->create();
    $this->lesson->update([
        'is_free_preview' => false,
    ]);

    $this->course->users()->attach($user->id);
    Livewire::actingAs($user)
        ->test(VideoPlayer::class, ['lesson' => $this->lesson])
        ->call('trackProgress', 123)
        ->call('markAsCompleted')
        ->assertHasNoErrors();
    $progress = LessonProgress::where('user_id', $user->id)
        ->where('lesson_id', $this->lesson->id)
        ->first();
    expect($progress)->not->toBeNull();
    expect($progress->completed_at)->not->toBeNull();
    expect($progress->watch_seconds)->toBe(123);
});
