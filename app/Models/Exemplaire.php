<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exemplaire extends Model
{

    protected $fillable = [
        'livre_id',
        'etat',
        'disponible'
    ];

    public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

}