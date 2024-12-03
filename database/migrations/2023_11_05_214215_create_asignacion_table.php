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
        Schema::create('asignacion', function (Blueprint $table) {
            $table->id();
            $table->string('unidad')->nullable();
            $table->integer('codactual')->nullable();
            $table->integer('codresp')->nullable();
            $table->integer('codofic')->nullable();
            $table->string('usuario')->nullable();
            $table->integer('descripcion');
            $table->integer('id_asignacion');
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
        Schema::dropIfExists('asignacion');
    }
};
