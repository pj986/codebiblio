<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{

    protected $fillable = [
        'user_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_effective'
    ];
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

public function exemplaires()
{
    return $this->belongsToMany(\App\Models\Exemplaire::class);
}
public function livre()
{
    return $this->belongsTo(\App\Models\Livre::class);
}
public function exemplaire()
{
    return $this->belongsTo(Exemplaire::class);
}
}