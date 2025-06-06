<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('user', function (Blueprint $table) {
        $table->enum('role', ['admin', 'kasir'])->default('kasir');
        $table->string('email'); // Tambahkan kolom name
    });
}

public function down()
{
    Schema::table('user', function (Blueprint $table) {
        $table->dropColumn('role');
        $table->dropColumn('email');
    });
}
};
