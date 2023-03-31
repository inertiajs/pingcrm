<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinery_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machinery_id')->index();
            $table->boolean('main')->default(false);
            $table->string('thumbnail')->nullable();
            $table->string('full')->nullable();

            $table->foreign('machinery_id')->references('id')->on('machineries')->onDelete('cascade');

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
        Schema::dropIfExists('machinery_images');
    }
}
