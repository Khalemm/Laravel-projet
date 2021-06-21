<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name');
            $table->bigInteger('tel_fixe')->nullable();
            $table->bigInteger('tel_mobile')->nullable();
            $table->string('nom_entreprise')->nullable();
            $table->string('adresse_entreprise')->nullable();
            $table->integer('code_postal')->nullable();
            $table->string('ville_entreprise')->nullable();
            //abonnement
            $table->boolean('admin')->default(0); //colonne admin
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
            //
        });
    }
}
