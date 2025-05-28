<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['web', 'auth']]);

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return true;
    // return (int) $user->id === (int) $id;
});

Broadcast::channel('mesasInfo', function ($user){
    return true;
});
