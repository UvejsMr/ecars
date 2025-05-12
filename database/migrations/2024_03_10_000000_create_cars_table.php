<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->integer('power');
            $table->integer('mileage');
            $table->string('gearbox');
            $table->string('fuel');
            $table->decimal('engine_size', 4, 1);
            $table->json('equipment');
            $table->text('description');
            $table->string('location');
            $table->decimal('price', 10, 2);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
}; 