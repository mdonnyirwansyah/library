<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('buku', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('peminjaman_id')->constrained('peminjaman', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku_peminjaman');
    }
}
