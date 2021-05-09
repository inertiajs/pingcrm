<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('account_id')->index();
          $table->string('issue');
          $table->text('description')->nullable();
          $table->unsignedInteger('status')->default(100);
          $table->unsignedInteger('priority')->nullable();
          $table->string('fix')->nullable();
          $table->string('assign')->nullable();
          $table->timestamp('due_date')->nullable();
          $table->timestamp('completed_date')->nullable();
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
        Schema::dropIfExists('issues');
    }
}
