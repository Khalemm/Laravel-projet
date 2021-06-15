<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRequetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requetes', function (Blueprint $table) {
            $table->float('longitude', 7, 1)->nullable();
            $table->float('latitude', 7, 1)->nullable();
            //$table->point('latitude','longitude');
            $table->string('adresse')->nullable();
            $table->integer('code_postal')->nullable();
            $table->string('nom_commune')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requetes', function (Blueprint $table) {
            //
        });
    }
}
