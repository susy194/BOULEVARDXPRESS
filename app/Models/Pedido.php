<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PedidoProducto;

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

    public function pedidoProducto()
    {
        return this->hasMany(PedidoProducto::class, 'id_pedido');
    }
}
