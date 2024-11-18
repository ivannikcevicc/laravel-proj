<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    Log::info('channelchannelchannel1111');
    return (int) $user->id === (int) $id;
});

Broadcast::channel('drivers', function ($user) {
    Log::info('channelchannelchannel');
    return true; // Add any authorization logic you need
});
