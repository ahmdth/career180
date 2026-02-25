<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);

        $levels = Level::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Beginner', 'slug' => 'beginner'],
                ['name' => 'Intermediate', 'slug' => 'intermediate'],
                ['name' => 'Advanced', 'slug' => 'advanced'],
            )
            ->create();

        $levels->each(function ($level) {
            $courses = Course::factory(2)->create(['level_id' => $level->id]);

            $courses->each(function ($course) {
                Lesson::factory(rand( 5, 10))->create(['course_id' => $course->id]);
            });
        });

        // Enroll the test user in a few courses
        $courses = Course::inRandomOrder()->take(3)->get();
        foreach ($courses as $course) {
            Enrollment::firstOrCreate([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
        }
    }
}
