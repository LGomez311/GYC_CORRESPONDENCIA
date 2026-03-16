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
        Schema::table('recibido', function (Blueprint $table) {
            $table->string('tipo_remitente', 50)->default('Persona')->after('nit_empresa');
            $table->string('radicado_empresa', 100)->nullable()->after('tipo_remitente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recibido', function (Blueprint $table) {
            $table->dropColumn(['tipo_remitente', 'radicado_empresa']);
        });
    }
};
