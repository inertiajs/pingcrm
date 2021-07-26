<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_rules', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('rule_category_id')->default(100);
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
        Schema::dropIfExists('office_rules');
    }
}
