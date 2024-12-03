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
        Schema::create('bajas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('entidad')->nullable();
            $table->string('unidad')->nullable();
            $table->string('codigo')->nullable();
            $table->integer('codbaja')->nullable();
            $table->integer('codcont')->nullable();
            $table->integer('codaux')->nullable();
            $table->integer('codofic')->nullable();
            $table->integer('codresp')->nullable();
            $table->double('costo')->nullable(); 
            $table->double('depacu_ant')->nullable();
            $table->string('descrip')->nullable();
            $table->string('d_baja')->nullable();
            $table->string('dia')->nullable(); 
            $table->string('m_baja')->nullable();
            $table->string('mes')->nullable(); 
            $table->string('a_baja')->nullable();
            $table->string('año')->nullable(); 
            $table->string('b_rev')->nullable();
            $table->integer('vidautil')->nullable();
            $table->string('resolucion')->nullable();
            $table->string('observ')->nullable();
            $table->string('motivo')->nullable();
            $table->double('depacu')->nullable();
            $table->double('actua')->nullable(); 
            $table->double('depgestion')->nullable();
            $table->double('cosbajini')->nullable();
            $table->double('cosdaini')->nullable(); 
            $table->double('cosactbaj')->nullable();
            $table->double('actdabaj')->nullable();
            $table->string('usuar')->nullable();
            $table->date('feult')->nullable();
            $table->string('fec_mod')->nullable();
            $table->string('usu_mod')->nullable();
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
        Schema::dropIfExists('bajas');
    }
};
