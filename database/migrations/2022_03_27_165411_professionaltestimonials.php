<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Professionaltestimonials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professionaltestimonials', function(Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('professional_id');
            $table->string('name');
            $table->float('rate');
            $table->string('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professionaltestimonials');
    }
}
