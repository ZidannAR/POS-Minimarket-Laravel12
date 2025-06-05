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
            Schema::create('customers',function(Blueprint $table){
            $table->increments('id_customers');
            $table->string('nama');
            $table->string('no_hp')->unique();
            $table->boolean('status_member')->default(false);
            $table->date('tanggal_daftar')->nullable();
            $table->integer('poin')->default(0);
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