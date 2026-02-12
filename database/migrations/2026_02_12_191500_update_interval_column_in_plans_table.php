<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add temporary integer column
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('interval_temp')->default(30);
        });

        // 2. Migrate data
        DB::table('plans')->get()->each(function ($plan) {
            $days = 30; // Default
            $val = strtoupper($plan->interval);
            
            if ($val === 'MONTHLY' || $val === '30') {
                $days = 30;
            } elseif ($val === 'YEARLY' || $val === '365') {
                $days = 365;
            } elseif (is_numeric($plan->interval)) {
                $days = (int) $plan->interval;
            }

            DB::table('plans')->where('id', $plan->id)->update(['interval_temp' => $days]);
        });

        // 3. Drop old column and rename new one
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('interval');
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->renameColumn('interval_temp', 'interval');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('interval')->default('monthly')->change();
        });

        // Convert back to string representation
        DB::table('plans')->where('interval', '30')->update(['interval' => 'monthly']);
        DB::table('plans')->where('interval', '365')->update(['interval' => 'yearly']);
    }
};
