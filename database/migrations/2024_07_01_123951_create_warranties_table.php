<?php

use App\Models\Branch;
use App\Models\Company;
use App\Models\Reparation;
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
        Schema::create('warranties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->comment('Empresa');
            $table->foreignIdFor(Branch::class)->comment('Sucursal');
            $table->date('start_date')->useCurrent()->comment('Fecha de inicio');
            $table->date('due_date')->useCurrent()->comment('Fecha de vencimiento');
            $table->mediumText('notes')->nullable()->default(null)->comment('Notas y observaciones');
            $table->foreignIdFor(Reparation::class)->nullable()->comment('Reparación');
            $table->boolean('active')->default(1)->comment('¿Está activa?');
            $table->foreignIdFor(User::class)->comment('Usuario creó o modificó');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranties');
    }
};
