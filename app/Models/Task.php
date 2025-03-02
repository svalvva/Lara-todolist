<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'cdeadline',
        'status',
        'id_user',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];
}