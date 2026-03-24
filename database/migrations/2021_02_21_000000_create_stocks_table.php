<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('stocks')) {
            return;
        }
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreignId('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->double('quantity')->default(0);
            $table->double('total_price')->default(0);
            $table->double('unit_price')->default(0);
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
        Schema::dropIfExists('stocks');
    }
};
