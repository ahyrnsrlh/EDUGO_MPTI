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
        Schema::table('payments', function (Blueprint $table) {
            // Add columns that don't exist yet
            if (!Schema::hasColumn('payments', 'payment_id')) {
                $table->string('payment_id')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('payments', 'external_id')) {
                $table->string('external_id')->nullable()->after('payment_id');
            }
            if (!Schema::hasColumn('payments', 'payment_url')) {
                $table->string('payment_url')->nullable()->after('status');
            }
            if (!Schema::hasColumn('payments', 'webhook_data')) {
                $table->json('webhook_data')->nullable()->after('payment_url');
            }
            if (!Schema::hasColumn('payments', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('payments', 'amount')) {
                $table->decimal('amount', 10, 2)->nullable()->after('total_amount');
            }
        });
        
        // Add indexes
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'payment_type') || !Schema::hasColumn('payments', 'external_id')) {
                // Skip index creation if columns don't exist
                return;
            }
            $table->index(['payment_type', 'external_id']);
            $table->index(['payment_type', 'payment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $existingColumns = Schema::getColumnListing('payments');
            
            // Drop indexes first
            try {
                $table->dropIndex(['payment_type', 'external_id']);
                $table->dropIndex(['payment_type', 'payment_id']);
            } catch (Exception $e) {
                // Ignore if index doesn't exist
            }
            
            // Drop columns if they exist
            $columnsToRemove = array_intersect(['payment_id', 'external_id', 'payment_url', 'webhook_data', 'user_id', 'amount'], $existingColumns);
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }
};
