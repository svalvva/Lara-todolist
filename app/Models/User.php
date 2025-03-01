<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Daftar kolom yang bisa diisi secara massal (mass assignment)
     * Ini adalah security feature Laravel untuk mencegah field yang tidak diinginkan diisi
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'id_role',  // Tambahkan id_role ke fillable
    ];

    /**
     * Daftar atribut yang harus disembunyikan saat model dikonversi ke array/JSON
     * Melindungi data sensitif seperti password
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Daftar atribut yang harus di-cast ke tipe data tertentu
     * Mengkonversi kolom database ke tipe data yang sesuai
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel roles
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
