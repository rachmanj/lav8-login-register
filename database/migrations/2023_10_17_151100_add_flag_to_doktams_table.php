<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagToDoktamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doktams', function (Blueprint $table) {
            $table->integer('spi_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->date('document_date')->after('doktams_po_no')->nullable();
            $table->string('flag')->nullable();
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doktams', function (Blueprint $table) {
            //
        });
    }
}
