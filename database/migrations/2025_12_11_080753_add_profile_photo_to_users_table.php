<?php
// ...
use Illuminate\Database\Migrations\Migration; // Pastikan ini diimpor!
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk menyimpan path foto profil (nullable karena opsional)
            $table->string('profile_photo')->nullable()->after('birth_date'); 
            // Catatan: Jika Anda tidak punya kolom 'birth_date', ganti after('...') ke kolom yang ada, misal after('email')
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop kolom jika di-rollback
            $table->dropColumn('profile_photo');
        });
    }
};