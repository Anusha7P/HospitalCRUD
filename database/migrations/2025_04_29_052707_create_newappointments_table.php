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
        Schema::create('newappointments', function (Blueprint $table) {
            $table->id();
            $table->foreign('hospital_name')->references('name')->on('hospitals')->onDelete('Cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('Cascade');
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('slots_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->dateTime('date_time')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newappointments');
    }
};
