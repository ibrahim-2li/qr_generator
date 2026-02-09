<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->options(function () {
                        return User::all()->pluck('name', 'id');
                    })
                    ->required(),
                Select::make('plan_id')
                    ->label('Plan')
                    ->options(function () {
                        return Plan::all()->pluck('name', 'id');
                    })
                    ->required(),
                Select::make('status')
                    ->options(Subscription::STATUS)
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
            ]);
    }
}
