<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Infolists;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Name')
                                    ->size('lg')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('email')
                                    ->label('Email Address')
                                    ->copyable()
                                    ->icon('heroicon-m-envelope'),

                                Infolists\Components\TextEntry::make('subject')
                                    ->label('Subject')
                                    ->size('lg'),

                                Infolists\Components\TextEntry::make('is_read')
                                    ->label('Status')
                                    ->formatStateUsing(fn (bool $state): string => $state ? 'Read' : 'Unread')
                                    ->badge()
                                    ->color(fn (bool $state): string => $state ? 'success' : 'warning'),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Received At')
                                    ->dateTime(),

                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime(),
                            ]),
                    ]),

                Section::make('Message')
                    ->schema([
                        Infolists\Components\TextEntry::make('message')
                            ->label('')
                            ->prose()
                            ->markdown()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
