<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivestocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livestocks', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->string('veterinarian');
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('species');
            $table->string('tag');
            $table->string('picture')->nullable(); // To store the picture path
            $table->timestamps();
            
        });
        
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livestocks');
    }
}
