<?php

namespace Tests\Feature;

use App\Livewire\Home;
use App\Models\Course;
use App\Models\Level;
use App\Models\User;
use Livewire\Livewire;

it("test_authenticated_users_can_visit_the_home_page", function (): void {
    $user = User::factory()->create();
    Livewire::actingAs($user);

    $response = Livewire::test(Home::class);
    $response->assertOk();
});

it('guests can visit the home page', function () {
    $response = Livewire::test(Home::class);
    $response->assertOk();
});

it('shows published courses', function () {
    $course = Course::factory()->create(['is_published' => true]);
    $response = Livewire::test(Home::class);
    $response->assertSee($course->title);
});

it('does not show unpublished courses', function () {
    $course = Course::factory()->create(['is_published' => false]);
    $response = Livewire::test(Home::class);
    $response->assertDontSee($course->title);
});

it('can search courses by title', function () {
    $course = Course::factory()->create(['is_published' => true, 'title' => 'UniqueTitle']);
    $response = Livewire::test(Home::class)
        ->set('search', 'UniqueTitle');
    $response->assertSee('UniqueTitle');
});

it('can filter courses by level', function () {
    $level = Level::factory()->create();
    $course = Course::factory()->create(['is_published' => true, 'level_id' => $level->id]);
    $response = Livewire::test(Home::class)
        ->set('levelId', $level->id);
    $response->assertSee($course->title);
});

it('shows pagination links', function () {
    Course::factory()->count(15)->create(['is_published' => true]);
    $response = Livewire::test(Home::class);
    $response->assertSee('Next');
});
