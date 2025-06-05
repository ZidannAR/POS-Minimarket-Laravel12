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
        // Migration untuk transaksi
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('diskon', 10, 2)->default(0);
           $table->unsignedInteger('id_customers')->nullable();
           $table->boolean('status_member')->default(false);
$table->foreign('id_customers')->references('id_customers')->on('customers');
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
