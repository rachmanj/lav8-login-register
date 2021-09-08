<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoktamsIdToAddocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irr5_addoc', function (Blueprint $table) {
            $table->unsignedBigInteger('doktams_id')->after('docreceive')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('irr5_addoc', function (Blueprint $table) {
            //
        });
    }
}
