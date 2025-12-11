<?php
// ...
use Illuminate\Database\Migrations\Migration; // <-- INI YANG KURANG
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom telepon (String, opsional/nullable)
            $table->string('phone', 15)->nullable()->after('email'); 
            
            // Kolom tanggal lahir (Date, opsional/nullable)
            $table->date('birth_date')->nullable()->after('phone'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop kolom jika di-rollback
            $table->dropColumn(['phone', 'birth_date']);
        });
    }
};