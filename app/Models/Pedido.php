<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PedidoProductos;

class Pedido extends Model
{
    protected $table      = 'pedidos';
    protected $primaryKey = 'id_pedido';
    protected $keyType    = 'int';
    public    $timestamps = false;

    protected $fillable = [
        "id_pedido",
        "ID_emp",
        "Fecha",
        "Hora",
        "Num_m",
        "Estado"
    ];

    public function pedidoProductos()
    {
        return $this->hasMany(PedidoProductos::class, 'id_pedido', 'id_pedido');
    }
}
