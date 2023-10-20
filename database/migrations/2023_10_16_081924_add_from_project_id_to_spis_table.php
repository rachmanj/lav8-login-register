<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromProjectIdToSpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spis', function (Blueprint $table) {
            $table->integer('from_project_id')->nullable();
            $table->string('from_department')->nullable();
            $table->string('to_department')->nullable();
            $table->string('flag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spis', function (Blueprint $table) {
            //
        });
    }
}
