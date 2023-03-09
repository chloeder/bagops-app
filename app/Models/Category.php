<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    public function berkas()
    {
        return $this->hasMany(Berkas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
