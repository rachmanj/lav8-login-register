<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('irr5_invoice', function (Blueprint $table) {
            // Add indexes to improve query performance
            $table->index('receive_date');
            $table->index('filename');
            $table->index('vendor_id');
            $table->index('inv_project');
            $table->index('po_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irr5_invoice', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['receive_date']);
            $table->dropIndex(['filename']);
            $table->dropIndex(['vendor_id']);
            $table->dropIndex(['inv_project']);
            $table->dropIndex(['po_no']);
        });
    }
};
