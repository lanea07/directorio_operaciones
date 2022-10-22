<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('usuario_de_red', 20);
            $table->string('nombre', 150);
            $table->string('correo', 150);
            $table->string('extension', 30);
            $table->foreignId('dependencia_id')->constrained()->onUpdate('cascade')->onDelete('restrict');;
            $table->foreignId('area_id')->constrained()->onUpdate('cascade')->onDelete('restrict');;
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->index(['usuario_de_red', 'nombre', 'correo']);
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
