<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->string('name', 100);
            $table->string('email', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('region', 50)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('postal_code', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
