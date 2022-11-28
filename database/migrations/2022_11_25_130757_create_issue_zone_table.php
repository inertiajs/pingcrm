<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_zone', function (Blueprint $table) {
            $table->foreignId('issue_id')->constrained('issues');
            $table->foreignId('departement_id')->constrained('departments');
            $table->foreignId('commune_id')->nullable()->constrained('communes');
            $table->foreignId('arrondissement_id')->nullable()->constrained('arrondissements');
            $table->foreignId('area_id')->nullable()->constrained('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_zone');
    }
}
