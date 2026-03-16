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
        Schema::table('detalle_envio', function (Blueprint $table) {
            $table->boolean('visto')->default(false)->after('folios_respuesta');
        });
        Schema::table('detalle_recibido', function (Blueprint $table) {
            $table->boolean('visto')->default(false)->after('folios_res');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_envio', function (Blueprint $table) {
            $table->dropColumn('visto');
        });
        Schema::table('detalle_recibido', function (Blueprint $table) {
            $table->dropColumn('visto');
        });
    }
};
