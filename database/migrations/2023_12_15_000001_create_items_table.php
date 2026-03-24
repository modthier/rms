<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('items')) {
            return;
        }
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price')->default(0);
            $table->double('weight')->nullable();
            $table->string('icon')->nullable();
            $table->foreignId('item_type_id')->nullable()->constrained('item_types')->onDelete('set null');
            $table->foreignId('ingredient_id')->nullable()->constrained('ingredients')->onDelete('set null');
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
