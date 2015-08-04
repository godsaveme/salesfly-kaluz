<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('empresa');
            $table->string('codigo');
            $table->string('direccionfiscal');
            $table->string('ruc');
            $table->string('numcuenta');
            $table->date('fechanac');
            $table->string('fijo');
            $table->string('movl');
            $table->string('email');
            $table->string('website');
            $table->string('genero');
            $table->string('direccontacto');
            $table->string('distrito');
            $table->string('twitter');
            $table->string('provincia');
            $table->string('departamento');
            $table->string('pais');
            $table->text('notas');
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
        Schema::drop('suppliers');
    }
}