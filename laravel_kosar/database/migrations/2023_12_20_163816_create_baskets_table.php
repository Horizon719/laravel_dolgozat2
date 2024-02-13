<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('baskets', function (Blueprint $table) {
            //a primary... nem hozza létre a mezőket...
            $table->primary(['user_id', 'item_id']);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('item_id')->references('item_id')->on('products');
            $table->timestamps();
        });

        DB::unprepared('CREATE TRIGGER increaseQuantity AFTER DELETE ON baskets FOR EACH ROW UPDATE products SET quantity = quantity + 1 WHERE item_id = OLD.item_id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baskets');
        DB::unprepared('DROP TRIGGER IF EXISTS increaseQuantity');
    }
};
