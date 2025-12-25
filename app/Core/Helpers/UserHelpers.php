<?php

use Illuminate\Contracts\Auth\Authenticatable;

function user() : ?Authenticatable {
    return auth()
        ->user();
}

function user_id() : ?int {
    return user()?->id;
}

function user_key() : ?string {
    return user()?->key;
}

function user_email() : ?string {
    return user()?->email;
}

function user_name() : ?string {
    return user()?->name;
}


function is_member() : bool {
    return !user()->is_admin;
}

function is_admin() : bool {
    return user()->is_admin;
}


