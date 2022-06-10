<?php

namespace MichaelNabil230\LaravelChat;

use MichaelNabil230\LaravelChat\Commands\LaravelChatCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelChatServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-chat')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-chat_table')
            ->hasCommand(LaravelChatCommand::class);
    }
}
