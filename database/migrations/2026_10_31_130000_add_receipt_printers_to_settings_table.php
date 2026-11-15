<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (! Schema::hasColumn('settings', 'customer_printer')) {
                $table->string('customer_printer')->nullable()->after('receipt_mode');
            }

            if (! Schema::hasColumn('settings', 'kitchen_printer')) {
                $table->string('kitchen_printer')->nullable()->after('customer_printer');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'kitchen_printer')) {
                $table->dropColumn('kitchen_printer');
            }

            if (Schema::hasColumn('settings', 'customer_printer')) {
                $table->dropColumn('customer_printer');
            }
        });
    }
};
