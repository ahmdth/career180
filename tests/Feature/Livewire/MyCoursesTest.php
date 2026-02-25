<?php

use App\Livewire\MyCourses;
use App\Models\Course;
use App\Models\User;
use Livewire\Livewire;

it('redirects guests to login', function () {
    Livewire::test(MyCourses::class)
        ->assertRedirect('/login');
});

it('shows empty state when user has no courses', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user)
        ->test(MyCourses::class)
        ->assertSee('You are not enrolled in any courses yet');
});

it('lists enrolled courses for user', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();
    $user->courses()->attach($course->id);

    Livewire::actingAs($user)
        ->test(MyCourses::class)
        ->assertSee($course->title);
});
