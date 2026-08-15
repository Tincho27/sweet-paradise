<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_quotes', function (Blueprint $table) {
            $table->enum('estado', [
                'pendiente',
                'en_revision',
                'presupuestado',
                'aceptado',
                'rechazado',
            ])->default('pendiente')->change();

            $table->string('servicio_otro')->nullable()->after('servicios');
            $table->string('producto_otro')->nullable()->after('productos_preferidos');

            $table->dropColumn('servicios');
            $table->string('servicio')->nullable()->after('fecha_evento');
        });
    }

    public function down(): void
    {
        Schema::table('event_quotes', function (Blueprint $table) {
            $table->dropColumn(['servicio_otro', 'producto_otro']);
            $table->dropColumn('servicio');
            $table->json('servicios')->nullable()->after('fecha_evento');

            $table->enum('estado', [
                'pendiente',
                'contactado',
                'cerrado',
            ])->default('pendiente')->change();
        });
    }
};
