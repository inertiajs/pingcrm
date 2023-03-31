<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machineries', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('brand_id')->index();
            $table->unsignedBigInteger('category_id');

            $table->string('no_serie')->unique();
            $table->string('model');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->date('acquisition_date')->nullable();
            $table->date('sale_date')->nullable();
            // $table->unsignedInteger('quantity')->default(0);
            // $table->boolean('active')->default(1);
            // $table->boolean('featured')->default(0);

            $table->foreign('category_id')->references('id')->on('categories');
            // $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('machineries');
    }
}
