<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->text('description')->nullable();
            $table->string('paymentMethod'); // BOLETO, CREDITO, DEBITO, PIX
            $table->timestamp('paymentDate')->nullable();
            $table->decimal('totalValue', 15, 2);

            $table->integer('clients_id')->unsigned()->index();
            $table->foreign('clients_id')->references('id')->on('clients');
            
            $table->timestamps();
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
        Schema::dropIfExists('payments');
    }
}
