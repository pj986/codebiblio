<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{

    protected $fillable = [
        'titre',
        'auteur',
        'categorie',
        'description',
        'couverture'
    ];

    public function exemplaires()
    {
        return $this->hasMany(Exemplaire::class);
    }

}