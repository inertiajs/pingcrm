<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('account_id')->index();
          $table->string('title');
          $table->text('description')->nullable();
          $table->unsignedInteger('status')->default(100);
          $table->unsignedInteger('priority')->nullable();
          $table->foreignId('creator')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
