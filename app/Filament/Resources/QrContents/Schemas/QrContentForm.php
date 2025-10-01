<?php

namespace App\Filament\Resources\QrContents\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class QrContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('qr_code_id')
                    ->required()
                    ->numeric(),
                FileUpload::make('profile_photo_path'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('company'),
                TextInput::make('linkedin'),
                TextInput::make('x'),
                TextInput::make('facebook'),
                TextInput::make('instagram'),
                TextInput::make('youtube'),
            ]);
    }
}
