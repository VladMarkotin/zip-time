<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('notification', function ($user, $id) {
    return true;
});


Broadcast::channel('ziptime-public', function ($user, $id) {
    return true;
});


Broadcast::channel('test.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
