<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarksToDoktamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doktams', function (Blueprint $table) {
            $table->string('grpo_no')->nullable();
            $table->date('grpo_date')->nullable();
            $table->date('ito_created_date')->nullable();
            $table->string('from_warehouse')->nullable();
            $table->string('to_warehouse')->nullable();
            $table->date('delivery_date')->nullable();
            $table->boolean('need_receiveback')->default(0);
            $table->date('receiveback_date')->nullable();
            $table->string('ta_no')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_duplicate')->default(0);
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
            $table->string('grpo_no')->nullable();
            $table->date('grpo_date')->nullable();
            $table->date('ito_created_date')->nullable();
            $table->string('from_warehouse')->nullable();
            $table->string('to_warehouse')->nullable();
            $table->date('delivery_date')->nullable();
            $table->boolean('need_receiveback')->default(0);
            $table->date('receiveback_date')->nullable();
            $table->string('ta_no')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_duplicate')->default(0);
        });
    }
}
