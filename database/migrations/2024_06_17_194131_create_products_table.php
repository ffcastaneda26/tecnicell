<?php

use App\Models\Brand;
use App\Models\DeviceModel;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)->comment('Marca');
            $table->string('name',150)->unique()->comment('Nombre');
            $table->string('slug',150)->unique()->comment('Slug');
            $table->mediumText('description')->nullable()->comment('Descripción');
            $table->string('image')->nullable()->comment('Imagen');
            $table->foreignIdFor(User::class)->comment('Usuario que creó o modificó');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
