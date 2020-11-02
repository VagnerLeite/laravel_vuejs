<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('cpf_titular', 18)->nullable(false)->change();
            $table->string('titular')->nullable(false)->change();
            $table->integer('bank_id')->unsigned()->nullable();
            $table->string('agency', 10)->nullable(false)->change();
            $table->string('account', 15)->nullable(false)->change();
            $table->integer('status')->unsigned()->nullable(false)->change();
            $table->char('type', 2)->nullable(false)->change();
            $table->string('operation', 5);
            $table->integer('supplier_id')->unsigned()->nullable();
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
        Schema::dropIfExists('bank_accounts');
    }
}
