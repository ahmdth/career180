<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Models\Level;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug'),
                Textarea::make('description')->rows(3),
                TextInput::make('image_url')->label('Image URL')->url(),
                Select::make('level_id')
                    ->label('Level')
                    ->options(Level::query()->pluck('name', 'id')->all()),
                Toggle::make('is_published')->label('Published')->default(false),
            ]);
    }
}
