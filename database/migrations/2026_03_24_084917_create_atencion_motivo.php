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
        Schema::create('atencion_motivo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('atencion_id')->constrained('atenciones')->onDelete('cascade');
            $table->foreignId('motivo_id')->constrained('motivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencion_motivo');
    }
};
