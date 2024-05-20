<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->uuid('uuid')->unique(); // UUID

            $table->text('description')->nullable();
            $table->decimal('value', 15, 2); //decimal(15,2)

            $table->timestamp('dateExecution')->default(DB::raw('CURRENT_TIMESTAMP')); // Corri bando de dados mysql defasado
            $table->timestamp('dateValidity')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->integer('clients_id')->unsigned()->index();
            $table->foreign('clients_id')->references('id')->on('clients');

            $table->integer('documents_id')->unsigned()->index();
            $table->foreign('documents_id')->references('id')->on('documents');

            $table->integer('payments_id')->unsigned()->index()->nullable();
            $table->foreign('payments_id')->references('id')->on('payments');

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
        Schema::dropIfExists('services');
    }
}
