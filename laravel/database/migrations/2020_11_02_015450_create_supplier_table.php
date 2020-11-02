<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id(); // id
            $table->char('tipo', 2)->null; // tipo do fornecedor (PF => Pessoa Fisica; PJ => Pessoa Juridica)
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable(false)->change();
            $table->text('endereco');
            $table->string('numero', 15);
            $table->string('bairro');
            $table->integer('city_id')->unsigned()->nullable(); // id da table cities
            $table->string('cnpj_cpf',18)->unique(); // Não permito dois cadastros com o mesmo CNPJ
            $table->string('logo');
            $table->string('slug');
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
        Schema::dropIfExists('supplier');
    }
}
