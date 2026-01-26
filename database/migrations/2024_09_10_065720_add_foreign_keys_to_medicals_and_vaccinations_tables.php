<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMedicalsAndVaccinationsTables extends Migration
{
    public function up()
    {
        Schema::table('medicals', function (Blueprint $table) {
            // Check if the foreign key does not already exist before adding it
            if (!Schema::hasColumn('medicals', 'livestock_id')) {
                $table->unsignedBigInteger('livestock_id');
            }
        
            // Drop the foreign key if it already exists
            $table->dropForeign(['livestock_id']);
            
            // Add the foreign key constraint
            $table->foreign('livestock_id')
                  ->references('id')
                  ->on('livestocks')
                  ->onDelete('cascade');
        });

        Schema::table('vaccinations', function (Blueprint $table) {
            // Drop the column if it exists and re-create it (Laravel should handle this properly)
            if (Schema::hasColumn('vaccinations', 'livestock_id')) {
                // Re-adding the foreign key
                $table->foreign('livestock_id')
                      ->references('id')
                      ->on('livestocks')
                      ->onDelete('cascade');
            }
        });
        
    }

    public function down()
    {
        Schema::table('medicals', function (Blueprint $table) {
            $table->dropForeign(['livestock_id']);
        });

        Schema::table('vaccinations', function (Blueprint $table) {
            $table->dropForeign(['livestock_id']);
        });
    }
}