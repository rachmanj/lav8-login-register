<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inv_id')->comment('Foreign key to irr5_invoice table');
            $table->string('filename')->comment('Original filename');
            $table->string('filepath')->comment('Path to stored file');
            $table->string('filetype')->nullable()->comment('File MIME type');
            $table->string('filesize')->nullable()->comment('File size in bytes');
            $table->text('description')->nullable()->comment('Description of the attachment');
            $table->string('uploaded_by')->nullable()->comment('User who uploaded the file');
            $table->timestamps();
            $table->softDeletes();
            
            // Remove the foreign key constraint for now
            // $table->foreign('inv_id')->references('inv_id')->on('irr5_invoice')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_attachments');
    }
}
