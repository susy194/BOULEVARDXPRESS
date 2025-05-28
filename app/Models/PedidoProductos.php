<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class PedidoProductos extends Model
{
    protected $table      = 'pedidos_productos';
    public    $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'id_prod',
        'cant_prod',
        'Nota_prod',
        'Estado_prod',
    ];

    public function productos()
    {
        return $this->belongsTo(Producto::class, 'id_prod');
    }

    public function getNombre()
    {
        return Producto::where('id_prod', $this->id_prod)->first()->Nombre;
    }
}
