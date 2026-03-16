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
            $table->unsignedInteger('id_recibido_padre')->nullable()->after('id_recibido');
            $table->foreign('id_recibido_padre')->references('id_recibido')->on('recibido')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recibido', function (Blueprint $table) {
            $table->dropForeign(['id_recibido_padre']);
            $table->dropColumn('id_recibido_padre');
        });
    }
};
