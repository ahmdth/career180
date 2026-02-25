<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Courses', Course::count())
                ->description('Number of courses available on the platform.')
                ->descriptionIcon('heroicon-o-book-open'),
            Stat::make('Enrollments', Enrollment::count())
                ->description('Total number of course enrollments.')
                ->descriptionIcon('heroicon-o-user-group'),
            Stat::make('Compeleted courses average', function () {
                $enrollments = Enrollment::count();
                if ($enrollments === 0) {
                    return '0%';
                }

                $completedCourses = CourseCompletion::count();
                $percentage = ($completedCourses / $enrollments) * 100;

                return number_format($percentage, 2).'%';
            })
                ->description('Percentage of enrollments that have been completed.')
                ->descriptionIcon('heroicon-o-check-circle'),
        ];
    }
}
