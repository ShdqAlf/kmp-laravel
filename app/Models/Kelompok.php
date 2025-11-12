<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'kelompok';

    protected $fillable = [
        'nama_kelompok',
    ];

    // Relasi dengan model User (Many-to-Many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'kelompok_user', 'kelompok_id', 'user_id');
    }
}
