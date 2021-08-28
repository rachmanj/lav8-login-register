<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoktamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doktams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoices_id');
            $table->unsignedBigInteger('doctypes_id');
            $table->string('document_no');
            $table->date('receive_date');
            $table->string('created_by');
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
        Schema::dropIfExists('doktams');
    }
}
