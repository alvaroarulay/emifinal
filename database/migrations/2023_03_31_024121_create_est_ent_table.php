<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('est_ent', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('gestion');
            $table->integer('sector_ent')->nullable();
            $table->integer('subsec_ent')->nullable();
            $table->integer('area_ent')->nullable();
            $table->integer('subareaent')->nullable();
            $table->integer('nivel_inst')->nullable();
            $table->string('des_estruc')->nullable();
            $table->string('siglaestru')->nullable();
            $table->string('apropiable')->nullable();
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
        Schema::dropIfExists('est_ent');
    }
};
