<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(['middleware' => ['web']]);

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('user.Chef', function ($user) {
    return $user->rol === "Chef";
});

Broadcast::channel('user.Mesero', function ($user) {
    \Log::info('Autenticando canal user.Mesero para usuario:', ['user' => $user]);
    return true; // Permitir acceso a todos los usuarios autenticados
});
