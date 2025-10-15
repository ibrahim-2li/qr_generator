<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Models\Plan;
use App\Models\User;
use App\Models\Subscription;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

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
