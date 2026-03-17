<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videojoc extends Model
{
    protected $fillable=['id','nom','plataforma','any_estrena','estat','preu'];

    public function completar(){

        $this->estat = 'COMPLETAT';
        $this->save();
    }

        public function jugar(){

        $this->estat = 'JUGANT';
        $this->save();
    }

        public function pendent(){

        $this->estat = 'PENDENT';
        $this->save();
    }

    public function detall(){

        return $this->hasOne(DetallVideojoc::class);
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }

    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class);
    }
}