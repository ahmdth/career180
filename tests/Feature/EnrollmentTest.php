<?php

use App\Livewire\CourseShow;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->course = Course::factory()->create(['is_published' => true]);

    $this->user = User::factory()->create();
});

it('requires login to enroll', function () {
    Livewire::test(CourseShow::class, ['course' => $this->course])
        ->call('enroll')
        ->assertRedirect('/login');
});

it('cannot enroll in draft courses', function () {
    $this->course->update(['is_published' => false]);
    $response = Livewire::actingAs($this->user)
        ->test(CourseShow::class, ['course' => $this->course])
        ->call('enroll');
    $response->assertForbidden();
    $this->assertDatabaseMissing('enrollments', [
        'user_id' => $this->user->id,
        'course_id' => $this->course->id,
    ]);
});

it('enrollment is idempotent', function () {
    Livewire::actingAs($this->user)
        ->test(CourseShow::class, ['course' => $this->course])
        ->call('enroll');
    $count = Enrollment::where('user_id', $this->user->id)->where('course_id', $this->course->id)->count();
    expect($count)->toBe(1);
});
