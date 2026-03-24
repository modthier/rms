<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE orders MODIFY total_price DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE order_details MODIFY price DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE purchase_orders MODIFY total_price DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE purchase_orders MODIFY quantity DECIMAL(14,3) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE stocks MODIFY quantity DECIMAL(14,3) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE stocks MODIFY total_price DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE stocks MODIFY unit_price DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE purchase_items MODIFY quantity DECIMAL(14,3) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE purchase_items MODIFY subtotal DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE daily_expenses MODIFY amount DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE expense_changes MODIFY amount DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE requirements MODIFY quantity DECIMAL(14,3) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE requirements MODIFY total_price DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE requirment_changes MODIFY quantity DECIMAL(14,3) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE requirment_changes MODIFY total_price DECIMAL(14,2) NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE daily_consumptions MODIFY quantity DECIMAL(14,3) NOT NULL DEFAULT 0');
    }

    public function down(): void
    {
        // Intentionally no-op: down-converting precision can lose data.
    }
};

