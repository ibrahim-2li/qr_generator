<?php

namespace App\Filament\Resources\QrCodes\Schemas;

use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;

class QrCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('QR Code Information')
                    ->schema([
                        TextInput::make('type')
                            ->required(),

                        Toggle::make('is_dynamic')
                            ->required(),
                    ]),

                Section::make('QR Content')
                    ->relationship('content')
                    ->schema([
                        FileUpload::make('profile_photo_path')
                            ->image()
                            ->disk('public')
                            ->directory('profile-photos')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/*'])
                            ->maxSize(2048),

                        TextInput::make('name')
                            ->required(),

                        TextInput::make('phone')
                            ->tel(),

                        TextInput::make('email')
                            ->email(),

                        TextInput::make('company'),

                        TextInput::make('linkedin')
                            ->url(),

                        TextInput::make('x')
                            ->url(),

                        TextInput::make('facebook')
                            ->url(),

                        TextInput::make('instagram')
                            ->url(),

                        TextInput::make('youtube')
                            ->url(),
                    ]),
            ]);
    }
}
