<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Professionalavailability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professionalavailability', function(Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('professional_id');
            $table->integer('weekday');
            $table->text('hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professionalavailability');
    }
}
