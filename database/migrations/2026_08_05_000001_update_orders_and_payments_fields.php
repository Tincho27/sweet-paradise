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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('email')->nullable()->after('user_id');
            $table->decimal('descuento', 10, 2)->nullable()->after('costo_envio');
            $table->decimal('extra', 10, 2)->nullable()->after('descuento');
            $table->renameColumn('estado', 'estado_orden');
            $table->renameColumn('fecha', 'fecha_estimada');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('estado', 'estado_pago');
            $table->renameColumn('fecha', 'fecha_pago');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('fecha_estimada', 'fecha');
            $table->renameColumn('estado_orden', 'estado');
            $table->dropColumn(['email', 'descuento', 'extra']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('estado_pago', 'estado');
            $table->renameColumn('fecha_pago', 'fecha');
        });
    }
};
