<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('subscription_id')
                    ->required()
                    ->numeric(),
                TextInput::make('payment_id'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required(),
                TextInput::make('payload'),
            ]);
    }
}
