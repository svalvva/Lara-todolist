<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['nama'];  // Change from 'name' to 'nama'

    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
}
