<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL-focused runtime index patch for existing deployments.
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $indexes = [
            'orders' => [
                'orders_created_at_idx' => ['created_at'],
                'orders_returned_created_idx' => ['returned', 'created_at'],
                'orders_user_created_idx' => ['user_id', 'created_at'],
                'orders_status_created_idx' => ['status', 'created_at'],
                'orders_payment_created_idx' => ['payment_id', 'created_at'],
            ],
            'order_details' => [
                'order_details_created_at_idx' => ['created_at'],
                'order_details_order_created_idx' => ['order_id', 'created_at'],
                'order_details_item_created_idx' => ['item_id', 'created_at'],
            ],
            'purchase_orders' => [
                'purchase_orders_created_at_idx' => ['created_at'],
                'purchase_orders_supplier_created_idx' => ['supplier_id', 'created_at'],
            ],
            'purchase_items' => [
                'purchase_items_created_at_idx' => ['created_at'],
                'purchase_items_purchase_created_idx' => ['purchase_id', 'created_at'],
                'purchase_items_ingredient_created_idx' => ['ingredient_id', 'created_at'],
            ],
            'daily_expenses' => [
                'daily_expenses_created_at_idx' => ['created_at'],
                'daily_expenses_user_created_idx' => ['user_id', 'created_at'],
                'daily_expenses_expense_created_idx' => ['expense_type_id', 'created_at'],
            ],
            'daily_consumptions' => [
                'daily_consumptions_created_at_idx' => ['created_at'],
                'daily_consumptions_stock_created_idx' => ['stock_id', 'created_at'],
            ],
            'requirements' => [
                'requirements_created_at_idx' => ['created_at'],
                'requirements_type_created_idx' => ['requirement_type_id', 'created_at'],
            ],
            'stocks' => [
                'stocks_created_at_idx' => ['created_at'],
                'stocks_ingredient_created_idx' => ['ingredient_id', 'created_at'],
            ],
            'attendances' => [
                'attendances_created_at_idx' => ['created_at'],
                'attendances_employee_created_idx' => ['employee_id', 'created_at'],
            ],
        ];

        foreach ($indexes as $table => $defs) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($defs as $name => $columns) {
                if (! $this->indexExists($table, $name)) {
                    $cols = implode(',', array_map(fn ($c) => "`{$c}`", $columns));
                    DB::statement("ALTER TABLE `{$table}` ADD INDEX `{$name}` ({$cols})");
                }
            }
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $drops = [
            'orders' => [
                'orders_created_at_idx',
                'orders_returned_created_idx',
                'orders_user_created_idx',
                'orders_status_created_idx',
                'orders_payment_created_idx',
            ],
            'order_details' => [
                'order_details_created_at_idx',
                'order_details_order_created_idx',
                'order_details_item_created_idx',
            ],
            'purchase_orders' => [
                'purchase_orders_created_at_idx',
                'purchase_orders_supplier_created_idx',
            ],
            'purchase_items' => [
                'purchase_items_created_at_idx',
                'purchase_items_purchase_created_idx',
                'purchase_items_ingredient_created_idx',
            ],
            'daily_expenses' => [
                'daily_expenses_created_at_idx',
                'daily_expenses_user_created_idx',
                'daily_expenses_expense_created_idx',
            ],
            'daily_consumptions' => [
                'daily_consumptions_created_at_idx',
                'daily_consumptions_stock_created_idx',
            ],
            'requirements' => [
                'requirements_created_at_idx',
                'requirements_type_created_idx',
            ],
            'stocks' => [
                'stocks_created_at_idx',
                'stocks_ingredient_created_idx',
            ],
            'attendances' => [
                'attendances_created_at_idx',
                'attendances_employee_created_idx',
            ],
        ];

        foreach ($drops as $table => $names) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($names as $name) {
                if ($this->indexExists($table, $name)) {
                    DB::statement("ALTER TABLE `{$table}` DROP INDEX `{$name}`");
                }
            }
        }
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $dbName = DB::getDatabaseName();
        $result = DB::selectOne(
            'SELECT COUNT(1) AS c
             FROM information_schema.statistics
             WHERE table_schema = ?
               AND table_name = ?
               AND index_name = ?',
            [$dbName, $table, $indexName]
        );

        return (int) ($result->c ?? 0) > 0;
    }
};

