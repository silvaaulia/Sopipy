<?php

// app/Models/Address.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    
    // Semua kolom yang akan dikirim dari form harus didaftarkan di sini
  // app/Models/Address.php

protected $fillable = [
    'user_id',          
    'label',            
    'recipient_name',   
    'phone_number',     
    // ... kolom lainnya
    'city',
    'postal_code',
    'is_default',
    'full_address', // <-- TAMBAHKAN INI
    // ...
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}