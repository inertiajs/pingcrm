<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
           
            $table->string('project_name',50);
            $table->string('resources', 100);
            $table->string('cost', 50)->nullable();
            $table->string('profit', 100)->nullable();
            $table->string('loss', 100)->nullable();
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
        Schema::dropIfExists('budgets');
    }
}
