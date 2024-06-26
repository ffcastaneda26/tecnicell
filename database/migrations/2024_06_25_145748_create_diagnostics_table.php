<?php

use App\Models\Branch;
use App\Models\Company;
use App\Models\Device;
use App\Models\User;
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
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->comment('Empresa');
            $table->foreignIdFor(Branch::class)->comment('Sucursal');
            $table->foreignIdFor(Device::class)->comment('Diagnóstico');
            $table->timestamp('date')->comment('Fecha del diagnóstico');
            $table->unsignedBigInteger('techincal_id')->comment('Técnico asignado');
            $table->mediumText('diagnosis')->comment('Diagnóstico');
            $table->foreignIdFor(User::class)->comment('Usuario que creó o modificó');
            $table->boolean('active')->default(1)->comment('¿Activo?');
            $table->timestamps();
            // LLave foránea
            $table->foreign('techincal_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostics');
    }
};
