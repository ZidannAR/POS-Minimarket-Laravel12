<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_detail', function ($table) {
            $table->increments('id_detail');

            
            $table->unsignedInteger('order_id');

            // Kolom lain yang diperlukan
            $table->unsignedInteger('id_produk');
            $table->integer('harga');

            

            // Baru tambahkan foreign key
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
