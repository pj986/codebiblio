<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    public function livre()
{
    return $this->belongsTo(\App\Models\Livre::class);
}
}
