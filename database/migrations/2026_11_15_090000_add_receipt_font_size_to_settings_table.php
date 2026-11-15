<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('settings', 'receipt_font_size')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->unsignedTinyInteger('receipt_font_size')->default(16)->after('receipt_mode');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('settings', 'receipt_font_size')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('receipt_font_size');
            });
        }
    }
};
