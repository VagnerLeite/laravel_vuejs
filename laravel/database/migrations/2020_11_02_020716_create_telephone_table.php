<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelephoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telephone', function (Blueprint $table) {
            $table->id();
            $table->integer('ddd', false, true)->nullable(false)->change();
            $table->integer('numero', false, true)->nullable(false)->change();
            $table->char('tipo', 1)->nullable(false)->change();
            $table->string('contato');
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
        Schema::dropIfExists('telephone');
    }
}
