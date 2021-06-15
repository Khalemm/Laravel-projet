<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requetes', function (Blueprint $table) {
            $table->id();
            $table->string('age_bien')->nullable();
            $table->string('type_bien')->nullable();
            $table->integer('nombre_pieces')->nullable();
            $table->integer('prix_min')->nullable();
            $table->integer('prix_max')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->constrained(); //clé étrangère id user
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requetes');
    }
}
