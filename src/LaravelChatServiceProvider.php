<?php

namespace MichaelNabil230\LaravelChat;

use MichaelNabil230\LaravelChat\Commands\LaravelChatCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelChatServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-chat')
            ->hasConfigFile()
            ->hasMigration('create_laravel-chat_table')
            ->hasCommand(LaravelChatCommand::class);
    }
}
