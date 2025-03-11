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
            // Add indexes for search fields
            try {
                $table->index('inv_no');
            } catch (\Exception $e) {
                // Index might already exist
            }

            try {
                $table->index('po_no');
            } catch (\Exception $e) {
                // Index might already exist
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irr5_invoice', function (Blueprint $table) {
            // Drop indexes
            try {
                $table->dropIndex(['inv_no']);
            } catch (\Exception $e) {
                // Index might not exist
            }

            try {
                $table->dropIndex(['po_no']);
            } catch (\Exception $e) {
                // Index might not exist
            }
        });
    }
};
