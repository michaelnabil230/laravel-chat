<?php
// config for MichaelNabil230/LaravelChat
return [

    'chatModel' => \MichaelNabil230\LaravelChat\Models\Chat::class,
    'messageModel' => \MichaelNabil230\LaravelChat\Models\Message::class,

    'notifyUsersDonstSeen' => [
        'time' => '-1 hour',
        'routeShow' => fn ($chatId) => route('chat.messages.show', $chatId),
    ],
];
