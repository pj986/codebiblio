<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $fillable = [
        'user_id',
        'livre_id'
    ];

    // 📚 Relation vers Livre
    public function livre()
    {
        return $this->belongsTo(\App\Models\Livre::class);
    }

    // 👤 Relation vers User (bonus propre)
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}