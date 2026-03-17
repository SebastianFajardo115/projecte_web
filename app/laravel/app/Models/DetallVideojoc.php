<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallVideojoc extends Model
{
    protected $fillable=['descripcio','duracio','pegi','videojoc_id'];

    public function videojoc(){

        return $this->belongsTo(Videojoc::class);
    }
}
