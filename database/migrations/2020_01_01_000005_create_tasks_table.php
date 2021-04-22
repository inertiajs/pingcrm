<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('account_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('task_id')->nullable();
            $table->foreignId('team_id')->nullable();
            $table->foreignId('project_id');
            $table->unsignedInteger('priority')->nullable();
            $table->unsignedInteger('status')->default(100);
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
        Schema::dropIfExists('tasks');
    }
}
