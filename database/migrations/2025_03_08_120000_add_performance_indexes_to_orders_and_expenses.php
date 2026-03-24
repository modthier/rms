<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds indexes for frequently queried columns to improve report and listing performance.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('status');
            $table->index('returned');
            $table->index('user_id');
            $table->index(['created_at', 'returned']);
        });

        if (Schema::hasTable('order_details')) {
            Schema::table('order_details', function (Blueprint $table) {
                $table->index('order_id');
                $table->index('item_id');
                $table->index('created_at');
            });
        }

        Schema::table('daily_expenses', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('expense_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['status']);
            $table->dropIndex(['returned']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at', 'returned']);
        });

        if (Schema::hasTable('order_details')) {
            Schema::table('order_details', function (Blueprint $table) {
                $table->dropIndex(['order_id']);
                $table->dropIndex(['item_id']);
                $table->dropIndex(['created_at']);
            });
        }

        Schema::table('daily_expenses', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['expense_type_id']);
        });
    }
};
