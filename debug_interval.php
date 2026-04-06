<?php
$plans = DB::table('plans')->get();
foreach($plans as $plan) {
    echo "ID: {$plan->id}, Interval: '{$plan->interval}'\n";
}
