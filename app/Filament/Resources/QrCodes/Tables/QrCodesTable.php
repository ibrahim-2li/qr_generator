<?php

namespace App\Filament\Resources\QrCodes\Tables;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
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
                ImageColumn::make('qr_code')
                    ->label('QR Code')
                    ->getStateUsing(function ($record) {
                        if (! $record->slug) {
                            return null;
                        }

                        $options = new QROptions([
                            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                            'eccLevel' => QRCode::ECC_L,
                            'scale' => 3,
                            'imageBase64' => true,
                        ]);

                        $qrcode = new QRCode($options);
                        $url = url('/q/'.$record->slug);

                        return $qrcode->render($url);
                    })
                    ->size(80)
                    ->square(),
                TextColumn::make('type')
                    ->searchable()
                    ->badge(),
                TextColumn::make('content.name')
                    ->label('Name')
                    ->searchable()
                    ->placeholder('PDF'),
                IconColumn::make('is_dynamic')
                    ->label('Dynamic')
                    ->boolean(),
                TextColumn::make('slug')
                    ->copyable()
                    ->placeholder('No slug'),
                TextColumn::make('scan_count')
                    ->label('Scans')
                    ->numeric()
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
            ]) ->defaultSort('created_at', 'desc')
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
