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
        
        Schema::create('resp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entidad')->nullable();
            $table->string('unidad')->nullable();
            $table->integer('codofic')->nullable();
            $table->integer('codresp')->nullable();
            $table->string('nomresp')->nullable();
            $table->string('cargo')->nullable();
            $table->string('observ')->nullable();
            $table->string('ci')->nullable();
            $table->string('feult')->nullable();
            $table->string('usuar')->nullable();
            $table->integer('cod_exp')->nullable();
            $table->integer('api_estado')->nullable();
            $table->integer('estado')->default(1);
            $table->integer('custodio')->default(0);
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
        Schema::dropIfExists('resp');
    }
};
