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
        // database/migrations/create_people_table.php
        // database/migrations/create_people_table.php
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->integer('age');
            $table->date('birthdate');
            $table->string('purok_no');
            $table->string('organization');
            $table->timestamps();
        
            $table->foreign('barangay_id')->references('id')->on('barangays')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
