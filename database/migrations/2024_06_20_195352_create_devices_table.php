<?php

use App\Models\User;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Company;
use App\Models\DeviceType;
use App\Models\DeviceModel;
use App\Models\DeviceStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->comment('Empresa');
            $table->foreignIdFor(Brand::class)->comment('Marca');
            $table->foreignIdFor(DeviceType::class)->comment('Tipo');
            $table->foreignIdFor(DeviceModel::class)->comment('Modelo');
            $table->string('serial_number',50)->nullable()->default(null)->comment('Número de serie');
            $table->string('imei',50)->nullable()->default(null)->comment('Código IMEI');
            $table->foreignIdFor(DeviceStatus::class)->comment('Estado');
            $table->mediumText('notes')->nullable()->default(null)->comment('Notas');
            $table->foreignIdFor(User::class)->comment('Usuario que creó o modificó');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
