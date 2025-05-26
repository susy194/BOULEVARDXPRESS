<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class PedidoProductos extends Model
{
    protected $table      = 'pedidos_productos';
    protected $primaryKey = 'id_pedido';
    public    $timestamps = false;


    public function productos()
    {
        return $this->belongsTo(Producto::class, 'id_prod');
    }

    public function getNombre()
    {
        return Producto::where('id_prod', $this->id_prod)->first()->Nombre;
    }
}
