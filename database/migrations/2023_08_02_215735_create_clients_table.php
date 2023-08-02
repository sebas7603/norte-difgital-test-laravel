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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->unique();
            $table->string('name', 20);
            $table->string('lastname', 20);
            $table->string('address_street', 40);
            $table->integer('address_number');
            $table->string('address_commune', 20);
            $table->string('address_city', 30);
            $table->string('phone', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
