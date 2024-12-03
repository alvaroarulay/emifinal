<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            
            $table->id();
            $table->string('unidad')->nullable(); 
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('condicion')->default(1);
            $table->integer('codresp')->unsigned()->nullable();
            $table->integer('codofic')->unsigned()->nullable();
            $table->integer('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
