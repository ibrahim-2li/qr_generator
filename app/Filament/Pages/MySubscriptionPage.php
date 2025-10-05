<?php

namespace App\Filament\Pages;

use App\Models\Payment;
use App\Models\Subscription;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MySubscriptionPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentCheck;

    protected static ?string $title = 'My Subscription';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.my-subscription-page';

    public $subscription;

    public function mount(): void
    {
        $this->subscription = Subscription::with('plan', 'payments')
            ->where('user_id', Auth::id())
            ->latest()
            ->first();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getPaymentsQuery())
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(function ($state) {
                        return number_format($state / 100, 2);
                    })
                    ->suffix(' SAR')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->alignEnd(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }

    protected function getPaymentsQuery(): Builder
    {
        if (!$this->subscription) {
            return Payment::query()->whereRaw('1 = 0'); // Empty query
        }

        return $this->subscription->payments()->getQuery();
    }

    public function renew(): void
    {
        if (! $this->subscription) {
            $this->dispatchBrowserEvent('no-subscription');
            return;
        }

        $plan = $this->subscription->plan;

        $response = Http::withBasicAuth(config('services.moyasar.secret'), '')
            ->post('https://api.moyasar.com/v1/payments', [
                'amount' => $plan->price,
                'currency' => 'SAR',
                'description' => "تجديد اشتراك {$plan->name}",
                'callback_url' => route('payment.callback'),
                'source' => [
                    'type' => 'creditcard',
                    'name' => 'عميل ميسر',
                    'number' => '4111111111111111',
                    'cvc' => '123',
                    'month' => '12',
                    'year' => '30',
                ],
            ]);

        $data = $response->json();

        $payment = $this->subscription->payments()->create([
            'payment_id' => $data['id'] ?? null,
            'amount' => $plan->price,
            'status' => $data['status'] ?? 'failed',
            'payload' => $data,
        ]);

        if (($data['status'] ?? '') === 'paid') {
            $this->subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
            ]);
        }

        $this->dispatchBrowserEvent('subscription-updated', [
            'status' => $this->subscription->status,
        ]);
    }

    public function cancel(): void
    {
        if ($this->subscription) {
            $this->subscription->update(['status' => 'canceled']);
            $this->dispatchBrowserEvent('subscription-canceled');
        }
    }
}
