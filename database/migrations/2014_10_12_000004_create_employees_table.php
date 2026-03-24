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
    public function up(): void
    {
        if (Schema::hasTable('employees')) {
            return;
        }
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('salary', 10, 2);
            $table->decimal('day_salary', 10, 2);
            $table->date('hire_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
