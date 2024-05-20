<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('fantasyName')->nullable();
            $table->string('companyName');
            $table->string('identificationName')->nullable();
            $table->string('documentNumber');
            $table->string('street');
            $table->string('neighborhood');
            $table->string('number');
            $table->string('zipcode');
            $table->string('city');
            $table->string('state');
            $table->string('complement')->nullable();
            $table->string('referencePoint')->nullable();
            $table->boolean('type')->default(0);
            $table->text('notes')->nullable();
            $table->string('respName')->nullable();
            $table->string('respPhone')->nullable();
            $table->string('respEmail')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
