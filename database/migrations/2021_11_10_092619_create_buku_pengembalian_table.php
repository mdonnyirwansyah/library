<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuPengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku_pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('buku', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->uuid('pengembalian_id')->nullable(false);
            $table->enum('status', [1, 0]);

            $table->foreign('pengembalian_id')->references('id')->on('pengembalian')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku_pengembalian');
    }
}
