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
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livestock_id'); // Foreign key to the Livestock table
            $table->date('date');
            $table->string('vaccination');
            $table->string('booster')->nullable();
            $table->timestamps();
          
        
            // Foreign key constraint
            $table->foreign('livestock_id')->references('id')->on('livestocks')->onDelete('cascade');
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
