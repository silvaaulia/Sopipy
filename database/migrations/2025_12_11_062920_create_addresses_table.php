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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (user_id)
            $table->foreignId('user_id')
                  ->constrained() // Membuat foreign key constraint
                  ->onDelete('cascade'); // Jika user dihapus, alamatnya ikut terhapus

            // Detail Alamat
            $table->string('label'); // Contoh: Rumah, Kantor
            $table->text('full_address'); // Alamat lengkap
            $table->string('city', 100); // Kota/Kabupaten
            $table->string('postal_code', 10); // Kode Pos
            
            // Status Utama
            $table->boolean('is_default')->default(false); // Penanda Alamat Utama

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};