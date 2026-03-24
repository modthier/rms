<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->references('id')->on('stocks')->onDelete('cascade');
            $table->foreignId('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreignId('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreignId('purchase_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->double('quantity');
            $table->double('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
};
