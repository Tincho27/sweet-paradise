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
        Schema::create('event_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('cantidad_personas')->nullable();
            $table->string('cantidad_personas_otro')->nullable();
            $table->date('fecha_evento')->nullable();
            $table->json('servicios')->nullable();
            $table->json('productos_preferidos')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('pendiente');
            $table->foreignId('converted_order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_quotes');
    }
};
