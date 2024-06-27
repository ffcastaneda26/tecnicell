<?php

use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\Device;
use App\Models\ReparationStatus;
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
        Schema::create('reparations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->comment('Empresa');
            $table->foreignIdFor(Branch::class)->comment('Sucursañ');
            $table->foreignIdFor(Client::class)->comment('Cliente');
            $table->foreignIdFor(Device::class)->comment('Dispositivo');
            $table->date('start_date')->nullable()->default(null)->comment('Fecha de Inicio');
            $table->date('finish_date')->nullable()->default(null)->comment('Fecha de Término');
            $table->decimal('cost',8,2)->comment('Costo de la reparación');
            $table->mediumText('notes')->nullable()->default(null)->comment('Notas');
            $table->foreignIdFor(User::class)->comment('Usuario que creó o modificó');
            $table->foreignIdFor(ReparationStatus::class)->comment('Estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparations');
    }
};
