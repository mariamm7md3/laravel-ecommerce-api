<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('admin-orders', function ($user) {
    return $user->is_admin ?? false;
});

Broadcast::channel('admin-message-sent', function ($user) {
    return $user->is_admin ?? false;
});
