<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable=['nom','descripcio','videojoc_id'];

    public function videojoc(){

        return $this->belongsTo(Videojoc::class);
    }
}