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
        Schema::table('event_quotes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->dropConstrainedForeignId('customer_id');
            $table->string('email')->nullable()->after('user_id');
            $table->string('telefono')->nullable()->after('email');
            $table->enum('estado', ['pendiente', 'contactado', 'cerrado'])
                ->default('pendiente')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_quotes', function (Blueprint $table) {
            $table->string('estado')->default('pendiente')->change();
            $table->dropColumn(['email', 'telefono']);
            $table->foreignId('customer_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
