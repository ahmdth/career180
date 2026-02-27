<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $with = ['level'];

    protected $fillable = [
        'level_id',
        'title',
        'slug',
        'description',
        'image_url',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withTimestamps()
            ->withPivot('enrolled_at');
    }

    public function courseCompletions()
    {
        return $this->hasMany(CourseCompletion::class);
    }

    public function completedUsers()
    {
        return $this->belongsToMany(User::class, 'course_completions')
            ->withTimestamps()
            ->withPivot('completed_at');
    }

    public function time()
    {
        $seconds = $this->lessons()->sum('duration_seconds');

        return gmdate('H:i:s', $seconds);
    }
}
