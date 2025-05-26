<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table      = 'Usuarios_Sistema';
    protected $primaryKey = 'ID_emp';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'usuario',
        'password'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];


    public function getAuthPassword()
    {
        return $this->password;
    }


    public function getRolAttribute()
    {
        $ID_tipo = DB::table('Usuarios_Sistema')
            ->where('usuario', $this->usuario)
            ->value('ID_tipo');

        if (! $ID_tipo) {
            return null;
        }

        $rol = DB::table('Tipo_Us')
            ->where('ID_Tipo', $ID_tipo)
            ->value('Tipo_Us');

        return $rol;
    }
}
