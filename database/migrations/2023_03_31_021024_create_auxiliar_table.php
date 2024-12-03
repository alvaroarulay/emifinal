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
        Schema::create('auxiliar', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('entidad')->nullable();
            $table->string('unidad')->nullable(); 
            $table->integer('codcont')->nullable();
            $table->integer('codaux')->nullable();
            $table->string('nomaux')->nullable();
            $table->string('observ')->nullable();
            $table->string('usuar')->nullable();
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
        Schema::dropIfExists('auxiliar');
    }
};
