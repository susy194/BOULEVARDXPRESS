<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PedidoProducto;

class Pedido extends Model
{
    protected $table      = 'pedidos';
    protected $primaryKey = 'id_pedido';
    public    $timestamps = false;

    public function pedidoProducto()
    {
        return this->hasMany(PedidoProducto::class, 'id_pedido');
    }
}
