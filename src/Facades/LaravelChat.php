<?php

namespace MichaelNabil230\LaravelChat\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MichaelNabil230\LaravelChat\LaravelChat
 */
class LaravelChat extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-chat';
    }
}
