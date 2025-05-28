<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Producto extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'id_prod';
    public    $timestamps = false;

    protected $fillable = [
        'Descripcion', 'Nombre', 'PRECIO', 'Cod_cat'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'Cod_cat', 'Cod_cat');
    }

    public function pedidos()
    {
        return $this->hasMany(PedidoProductos::class, 'id_prod');
    }
}
