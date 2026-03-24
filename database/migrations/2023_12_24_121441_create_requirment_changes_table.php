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
        Schema::create('requirment_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
            $table->double('quantity');
            $table->double('total_price');
            $table->foreignId('requirement_type_id')->references('id')->on('requirement_types')->onDelete('cascade');
            $table->foreignId('unit_id')->references('id')->on('units')->onDelete('cascade');
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
        Schema::dropIfExists('requirment_changes');
    }
};
