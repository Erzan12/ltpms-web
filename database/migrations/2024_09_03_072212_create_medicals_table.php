<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('medicals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('livestock_id'); // Add livestock_id column
            $table->string('treatment');
            $table->text('note');
            $table->timestamps();

            // Add the foreign key relationship to livestock
            $table->foreign('livestock_id')->references('id')->on('livestocks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicals');
    }
};
