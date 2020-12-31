<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinutasParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minutas_participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('minuta_id')->constrained('minutas');
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('nombre', 191);
            $table->string('apellido_paterno', 191);
            $table->string('apellido_materno', 191);
            $table->string('firma', 191);
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
        Schema::dropIfExists('minutas_participantes');
    }
}
