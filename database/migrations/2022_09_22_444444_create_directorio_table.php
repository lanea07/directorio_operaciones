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
        Schema::create('directorios', function (Blueprint $table) {
            $table->id();

            $table->text('usuario_de_red');
            $table->text('nombre');
            $table->text('correo');
            $table->text('extension');
            $table->timestamps();
        });

        Schema::table('directorios', function(Blueprint $table){
            $table->foreignId('dependencia_id')->constrained()->onUpdate('cascade')->onDelete('restrict');;
            $table->foreignId('area_id')->constrained()->onUpdate('cascade')->onDelete('restrict');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directorios');
    }
};
