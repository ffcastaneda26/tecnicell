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
        Schema::create('regimenes_fiscales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->comment('Código de régimen fiscal');
            $table->string('nombre')->unique()->comment('Nombre del régimen fiscal');
            $table->boolean('fisicas')->default(1)->comment('Personas Físicas?');
            $table->boolean('morales')->default(1)->comment('Personas Morales?');
            $table->date('inicio_vigencia')->nullable()->comment('Fecha inicio de vigencia');
            $table->date('fin_vigencia')->nullable()->comment('Fecha fin de vigencia');
            $table->boolean('active')->default(1)->comment('¿Activo?');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regimenes_fiscales');
    }
};
