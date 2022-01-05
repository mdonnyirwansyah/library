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
            $table->integerIncrements('id');
            $table->integer('buku_id');
            $table->integer('pengembalian_id');
            $table->enum('status', [1, 0]);
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
