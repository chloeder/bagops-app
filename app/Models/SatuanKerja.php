<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanKerja extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'satuan_kerja_id', 'id');
    }

    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }
}
