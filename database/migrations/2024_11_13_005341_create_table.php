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
        Schema::create('roles', function (Blueprint $table) {
            $table->integer('id', true)->length(11);
            $table->string('name')->default('peminjam');
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->integer('UserID', false)->length(11);
            $table->integer('role_id', false)->length(11);
            $table->foreign('UserID')->references('UserID')->on('users')->cascadeOnDelete();
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
            $table->primary(['UserID', 'role_id']);
        });

        Schema::create('buku', function (Blueprint $table) {
            $table->integer('BukuID', true)->length(11);
            $table->string('Judul', 255);
            $table->string('Penulis', 255);
            $table->string('Penerbit', 255);
            $table->string('image', 255)->nullable();
            $table->integer('TahunTerbit')->length(11);
            $table->timestamps();
        });

        Schema::create('kategoribuku', function (Blueprint $table) {
            $table->integer('KategoriID', true)->length(11);
            $table->string('NamaKategori', 255);
            $table->text('deskripsi')->nullable();
        });

        Schema::create('kategoribuku_relasi', function (Blueprint $table) {
            $table->integer('KategoriBukuID', true)->length(11);
            $table->integer('BukuID', false)->length(11);
            $table->integer('KategoriID', false)->length(11);
            $table->foreign('BukuID')->references('BukuID')->on('buku')->cascadeOnDelete();
            $table->foreign('KategoriID')->references('KategoriID')->on('kategoribuku')->cascadeOnDelete();
        });

        Schema::create('ulasanbuku', function (Blueprint $table) {
            $table->integer('UlasanID', true)->length(11);
            $table->integer('UserID', false)->length(11);
            $table->integer('BukuID', false)->length(11);
            $table->foreign('UserID')->references('UserID')->on('users')->cascadeOnDelete();
            $table->foreign('BukuID')->references('BukuID')->on('buku')->cascadeOnDelete();
            $table->text('Ulasan')->nullable();
            $table->integer('Rating')->nullable();
            $table->timestamps();
        });

        Schema::create('koleksipribadi', function (Blueprint $table) {
            $table->integer('KoleksiID', true)->length(11);
            $table->integer('UserID', false)->length(11);
            $table->integer('BukuID', false)->length(11);
            $table->foreign('UserID')->references('UserID')->on('users')->cascadeOnDelete();
            $table->foreign('BukuID')->references('BukuID')->on('buku')->cascadeOnDelete();
        });

        Schema::create('peminjaman', function (Blueprint $table) {
            $table->integer('PeminjamanID', true, )->length(11);
            $table->integer('UserID', false)->length(11);
            $table->integer('BukuID', false)->length(11);
            $table->foreign('UserID')->references('UserID')->on('users')->cascadeOnDelete();
            $table->foreign('BukuID')->references('BukuID')->on('buku')->cascadeOnDelete();
            $table->date('TanggalPeminjaman');
            $table->date('TanggalPengembalian');
            $table->string('StatusPeminjaman', 50);
            $table->timestamps();
        });

        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->integer('UserID')->nullable();
            $table->string('aksi');
            $table->text('detail')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('UserID')->references('UserID')->on('users')->nullOnDelete();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('peminjaman');
        Schema::dropIfExists('koleksipribadi');
        Schema::dropIfExists('ulasanbuku');
        Schema::dropIfExists('kategoribuku_relasi');
        Schema::dropIfExists('kategoribuku');
        Schema::dropIfExists('buku');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('roles');
    }
};
