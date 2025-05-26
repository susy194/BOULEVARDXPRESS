<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Categoria extends Model
{
    protected $table      = 'categoria';
    protected $primaryKey = 'Cod_cat';
    public    $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'Cod_cat');
    }
}
