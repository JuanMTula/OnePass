<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateclavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claves', function (Blueprint $table) {
            $table->integer('claves_id')->autoIncrement();
            $table->integer('claves_contid');
            $table->longText('claves_titulo');
            $table->longText('claves_texto');
            $table->longText('claves_tipo');
            $table->longText('claves_color');
            $table->longText('claves_url');
            $table->longText('claves_tel');
            $table->longText('claves_cuenta');
            $table->longText('claves_clave');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claves');
    }
}
