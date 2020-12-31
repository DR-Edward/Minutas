<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinutasAcuerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minutas_acuerdos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('minuta_id')->constrained('minutas');
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('responsable', 191);
            $table->string('actividad', 191);
            $table->date('fecha_compromiso');
            $table->softDeletes();
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
        Schema::dropIfExists('minutas_acuerdos');
    }
}
