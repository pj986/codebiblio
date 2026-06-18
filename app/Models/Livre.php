<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'auteur',
        'description',
        'categorie',
        'couverture'
    ];
     public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }
    public function exemplaires()
{
    return $this->hasMany(\App\Models\Exemplaire::class);
}
}