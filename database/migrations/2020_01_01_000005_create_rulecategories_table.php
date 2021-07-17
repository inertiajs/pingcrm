<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('instructor_id')->nullable();
            $table->unsignedInteger('priority')->nullable();
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
        Schema::dropIfExists('rule_categories');
    }
}
