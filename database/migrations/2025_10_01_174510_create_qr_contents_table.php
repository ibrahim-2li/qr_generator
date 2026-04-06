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
        Schema::create('qr_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(QrCode::class)->constrained()->cascadeOnDelete();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('company')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('x')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_contents');
    }
};
