<?php

namespace App\Filament\Resources\Lessons\Schemas;

use App\Models\Course;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title'),
                Select::make('course_id')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => Course::query()
                        ->where('title', 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('title', 'id')
                        ->all())
                    ->getOptionLabelUsing(fn ($value): ?string => Course::find($value)?->title),
                TextInput::make('duration_seconds')->label('Duration Seconds')->numeric(),
                TextInput::make('video_url')->label('Video URL')->url(),
                TextInput::make('order')->numeric(),
                Toggle::make('is_free_preview')->label('Free Preview')->default(false),
            ]);
    }
}
