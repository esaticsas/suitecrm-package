<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_modules', function (Blueprint $table) {
            $table->string('relation_name')->primary();
            $table->string('related_table');
            $table->string('primary_table');
            $table->string('related_field');
            $table->string('filter_field');
            $table->boolean('cstm')->default(true);
            $table->string('module');
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
        Schema::dropIfExists('related_modules');
    }
}
