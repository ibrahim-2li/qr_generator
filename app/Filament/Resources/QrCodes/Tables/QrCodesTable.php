<?php

namespace App\Filament\Resources\QrCodes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QrCodesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable()
                    ->badge(),
                TextColumn::make('content.name')
                    ->label('Name')
                    ->searchable()
                    ->placeholder('No content'),
                IconColumn::make('is_dynamic')
                    ->label('Dynamic')
                    ->boolean(),
                TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->placeholder('No slug'),
                TextColumn::make('scan_count')
                    ->label('Scans')
                    ->numeric()
                    ->sortable()
                    ->badge(),
                TextColumn::make('user.name')
                    ->label('Created By')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
