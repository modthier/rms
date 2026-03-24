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
        Schema::create('expense_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_expense_id')->references('id')->on('daily_expenses')->onDelete('cascade');
            $table->foreignId('expense_type_id')->references('id')->on('expense_types')->onDelete('cascade');
            $table->double('amount');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('expense_changes');
    }
};
