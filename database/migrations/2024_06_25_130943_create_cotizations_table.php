<?php

use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\CotizationStatus;
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
        Schema::create('cotizations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->comment('Empresa');
            $table->foreignIdFor(Branch::class)->comment('Sucursañ');
            $table->foreignIdFor(Client::class)->comment('Cliente');
            $table->foreignIdFor(Device::class)->comment('Dispositivo');
            $table->mediumText('description')->comment('Descripción');
            $table->decimal('estimated_cost',8,2)->default(0)->comment('Costo Estimado');
            $table->foreignIdFor(CotizationStatus::class)->comment('Estado de la cotización');
            $table->boolean('client_approved')->default(0)->comment('¿Aprobado por cliente');
            $table->timestamp('approval_date')->nullable()->default(null)->comment('Fecha de aprobación');
            $table->foreignIdFor(User::class)->comment('Usuario que creó o modificó');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizations');
    }
};
