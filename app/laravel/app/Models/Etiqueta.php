<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    protected $fillable=['nom','videojoc_id'];

    public function videojoc(){

        return $this->belongsTo(Videojoc::class);
    }
}
