<?php

use App\Models\QrCode;
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
        Schema::create('qr_pdfs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(QrCode::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('file');
            $table->string('color_l')->nullable();
            $table->string('color_d')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_pdfs');
    }
};
