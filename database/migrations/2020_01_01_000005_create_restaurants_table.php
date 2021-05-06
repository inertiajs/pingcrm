<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('custmer_name', 100);
            $table->string('phone', 50)->nullable();
            $table->string('custmer_order', 50)->nullable();
            $table->string('custmer_address', 150)->nullable();
            $table->string('restaurant_name', 150)->nullable();
            $table->string('bill_no', 50)->nullable();
            $table->string('feedback', 50)->nullable();
            $table->string('payment_method', 50)->nullable();
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
        Schema::dropIfExists('restaurants');
    }
}
