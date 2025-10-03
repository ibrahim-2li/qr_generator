<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('qr_contents', function (Blueprint $table) {
            $table->string('color_l')->nullable()->after('qr_code_id');
            $table->string('color_d')->nullable()->after('color_l');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qr_contents', function (Blueprint $table) {
            $table->dropColumn('color_l');
            $table->dropColumn('color_d');
        });
    }
};
