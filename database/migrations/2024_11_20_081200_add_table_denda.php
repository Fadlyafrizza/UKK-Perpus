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
        Schema::create('denda', function (Blueprint $table) {
            $table->integer('DendaID', true)->length(11);
            $table->integer('PeminjamanID', false)->length(11);
            $table->integer('UserID', false)->length(11);
            $table->integer('BukuID', false)->length(11);
            $table->integer('JumlahDenda');
            $table->string('StatusPembayaran', 50)->default('Belum Dibayar');
            $table->date('TanggalDenda');
            $table->text('Keterangan')->nullable();
            $table->timestamps();

            $table->foreign('PeminjamanID')->references('PeminjamanID')->on('peminjaman')->cascadeOnDelete();
            $table->foreign('UserID')->references('UserID')->on('users')->cascadeOnDelete();
            $table->foreign('BukuID')->references('BukuID')->on('buku')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
