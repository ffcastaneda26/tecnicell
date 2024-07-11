<?php

use App\Models\Company;
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
        Schema::create('key_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->comment('Empresa');
            $table->string('name_spanish',50)->comment('Nombre en español');
            $table->string('short_spanish',6)->comment('Corto en español');
            $table->string('name_english',50)->comment('Nombre en inglés');
            $table->string('short_english',6)->comment('Corto en inglés');
            $table->string('used_to',10)->comment('Usarse para: I=Inventory S=Sale');
            $table->string('type')->comment('Tipo: I=Input O=Output');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_movements');
    }
};
