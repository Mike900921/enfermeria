<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id'); // ID del paciente en sep_participante
            $table->unsignedBigInteger('users_id');  // ID del personal de enfermería
            $table->unsignedBigInteger('ficha_id'); //ID de la ficha
            $table->dateTime('fecha_hora');
            $table->string('motivo');
            $table->text('procedimientos')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Relación con el personal de enfermería
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('atenciones');
    }
};
