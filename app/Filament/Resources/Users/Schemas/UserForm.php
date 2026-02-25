<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context): bool => $context === 'create')
                ->rule(Password::defaults()),

            TextInput::make('password_confirmation')
                ->password()
                ->required(fn (string $context): bool => $context === 'create')
                ->same('password')
                ->dehydrated(false),

            Select::make('role')
                ->options([
                    'user' => 'User',
                    'admin' => 'Administrator',
                ])
                ->required()
                ->default('user'),
        ]);
    }
}
