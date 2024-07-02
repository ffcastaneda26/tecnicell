<?php

use App\Models\Branch;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->comment('Empresa');
            $table->foreignIdFor(Branch::class)->comment('Sucursal');
            $table->string('name',100)->comment('Nombre');
            $table->string('short',20)->comment('Corto');
            $table->string('email')->nullable()->default(null)->comment('Correo Electrónico');

            $table->string('phone',15)->nullable()->default(null)->comment('Teléfono');
            $table->string('address',80)->nullable()->default(null)->comment('Dirección calle');
            $table->string('num_ext',6)->nullable()->default(null)->comment('Número Exterior');
            $table->string('num_int',6)->nullable()->default(null)->comment('Número Interior');
            $table->foreignIdFor(Country::class)->nullable()->default(135)->comment('País');
            $table->foreignIdFor(State::class)->nullable()->default(7)->comment('Entidad Federativa');
            $table->string('municipality',100)->nullable()->default(null)->comment('Municipio');
            $table->string('city',100)->nullable()->default(null)->comment('Ciudad');
            $table->string('colony',100)->nullable()->default(null)->comment('Colonia');
            $table->string('zipcode',5)->nullable()->default(null)->comment('Código Postal');
            $table->boolean('active')->default(1)->comment('¿Está activo?');
            $table->foreignIdFor(User::class)->comment('Usuario que creó o modificó');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
