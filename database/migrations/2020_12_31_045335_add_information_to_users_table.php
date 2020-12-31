<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInformationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido_paterno', 191)->after('name');
            $table->string('apellido_materno', 191)->after('apellido_paterno');
            $table->date('fecha_nacimiento')->after('apellido_materno');
            $table->char('sexo', 191)->after('fecha_nacimiento');
            $table->string('imagen', 191)->after('email_verified_at');
            $table->string('firma', 191)->after('imagen');
            $table->string('token_firebase', 191)->after('firma');
            $table->boolean('solicitar')->after('password');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'apellido_paterno',
                'apellido_materno',
                'fecha_nacimiento',
                'sexo',
                'imagen',
                'firma',
                'token_firebase',
                'solicitar',
            ]);
        });
    }
}
