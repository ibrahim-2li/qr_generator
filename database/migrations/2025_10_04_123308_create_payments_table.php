<?php

use App\Models\Subscription;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Subscription::class)->constrained()->onDelete('cascade');
            $table->string('payment_id')->nullable(); // ID من Moyasar
            $table->integer('amount');
            $table->string('status'); // paid | failed
            $table->json('payload')->nullable(); // تفاصيل الاستجابة من Moyasar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
