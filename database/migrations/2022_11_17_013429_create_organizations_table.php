<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->index();
            $table->string('name', 100);
            $table->string('phone', 50)->nullable();
            $table->string('address', 150)->nullable();
            $table->enum('centre', ['commercial', 'tech'])->default('commercial');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('commune_id')->constrained('communes');
            $table->foreignId('arrondissement_id')->nullable()->constrained('arrondissements');
            $table->foreignId('area_id')->nullable()->constrained('areas');
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
        Schema::dropIfExists('organizations');
    }
}
