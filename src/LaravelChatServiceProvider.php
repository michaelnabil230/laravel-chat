<?php

namespace MichaelNabil230\LaravelChat;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MichaelNabil230\LaravelChat\Commands\LaravelChatCommand;

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
