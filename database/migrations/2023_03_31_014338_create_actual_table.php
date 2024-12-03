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
        
        Schema::create('actual', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unidad')->nullable(); 
            $table->string('entidad')->nullable();
            $table->string('codigo')->nullable();
            $table->integer('codcont')->unsigned();
            $table->integer('codaux')->nullable();
            $table->integer('vidautil')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('costo')->nullable();
            $table->integer('depacu')->nullable();
            $table->integer('mes')->nullable(); 
            $table->integer('año')->nullable(); 
            $table->string('b_rev')->nullable();
            $table->integer('dia')->nullable(); 
            $table->integer('codofic')->nullable();
            $table->integer('codresp')->unsigned();
            $table->string('observ')->nullable();
            $table->integer('dia_ant')->nullable(); 
            $table->integer('mes_ant')->nullable(); 
            $table->integer('año_ant')->nullable();
            $table->integer('vut_ant')->nullable();
            $table->integer('costo_ant')->nullable();
            $table->string('band_ufv')->nullable(); 
            $table->integer('codestado')->nullable();
            $table->string('cod_rube')->nullable();
            $table->string('nro_conv')->nullable();
            $table->string('org_fin')->nullable();
            $table->string('usuar')->nullable();
            $table->string('api_estado')->nullable();
            $table->string('codigosec')->nullable();
            $table->string('banderas')->nullable();
            $table->string('fec_mod')->nullable();
            $table->string('usu_mod')->nullable();
            $table->integer('codimage')->nullable();
            $table->integer('estadoasignacion')->default(1);
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
        Schema::dropIfExists('actual');
    }
};
