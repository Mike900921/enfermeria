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
        Schema::table('atenciones', function (Blueprint $table) {
            $table->dropForeign(['motivo_id']); // si existe FK
            $table->dropColumn('motivo_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atenciones', function (Blueprint $table) {
            //
        });
    }
};
