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
        Schema::create('entidades', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('gestion')->nullable(); 
            $table->string('entidad')->nullable();
            $table->string('desc_ent')->nullable();
            $table->string('sigla_ent')->nullable();
            $table->integer('sector_ent')->nullable();
            $table->integer('subsec_ent')->nullable();
            $table->integer('area_ent')->nullable();
            $table->integer('subareaent')->nullable();
            $table->integer('nivel_inst')->nullable();
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
        Schema::dropIfExists('entidades');
    }
};
