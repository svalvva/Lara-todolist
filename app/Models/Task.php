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
        'deadline',
        'status',
        'id_user'
    ];

    protected $casts = [
        'deadline' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'tertunda'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Scope untuk pencarian dan filter task
     */
    public function scopeSearch($query, $filters)
    {
        return $query
            ->when($filters['search'] ?? false, function($query, $search) {
                $query->where('judul', 'like', '%' . $search . '%');
            })
            ->when($filters['status'] ?? false, function($query, $status) {
                $query->where('status', $status);
            })
            ->where('id_user', auth()->id()); // Pastikan hanya mengambil tasks milik user yang login
    }

    /**
     * Scope untuk mendapatkan jumlah task berdasarkan status
     */
    public function scopeCountByStatus($query, $status = null)
    {
        return $query->where('id_user', auth()->id())
            ->when($status, function($query, $status) {
                $query->where('status', $status);
            })
            ->count();
    }
}