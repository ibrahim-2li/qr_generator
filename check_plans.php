<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$plans = App\Models\Plan::all(['id', 'name', 'interval']);
foreach ($plans as $plan) {
    echo "ID: {$plan->id}, Name: {$plan->name}, Interval: '{$plan->interval}'\n";
}
