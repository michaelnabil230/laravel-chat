<?php

namespace MichaelNabil230\LaravelChat\Http\Controllers;

use MichaelNabil230\LaravelChat\Events\Message as MessageEvent;
use MichaelNabil230\LaravelChat\Http\Resources\Conversation\ConversationCollection;
use MichaelNabil230\LaravelChat\Http\Resources\Message\MessageCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MichaelNabil230\LaravelChat\Models\Conversation;

class ConversationController
{
    public function index()
    {
        $type = str(Auth::getProvider()->getProviderName())->singular();

        $load = $type->is('user') ? 'nurse' : 'user';

        $conversations = Conversation::query()
            ->with([$load, 'lastMessage', 'appointment'])
            ->where($type->append('_id')->value(), auth()->id())
            ->latest()
            ->paginate();

        return response()->json([
            'conversations' => ConversationCollection::make($conversations),
        ]);
    }

    public function getMessages(Conversation $conversation)
    {
        $type = auth('user-api')->check() ? Nurse::class : User::class;

        $conversation->unRead($type);

        $messages = $conversation
            ->messages()
            ->with('senderable')
            ->latest()
            ->paginate();

        return response()->json([
            'messages' => MessageCollection::make($messages),
        ]);
    }

    public function send(Request $request, Conversation $conversation)
    {
        $request->validate([
            'body' => ['required'],
            'attachments' => ['array']
        ]);

        $attachments = collect();

        foreach ($request->collect('attachments') as $attachment) {
            $attachments->push($attachment->store('public/messages'));
        }

        /** @var \Illuminate\Database\Eloquent\Model $user */
        $user = auth()->user();

        $message = $conversation->messages()->create([
            'body' => $file ?? $request->body,
            'attachments' => $attachments,
            'senderable_type' => $user->getMorphClass(),
            'senderable_id' => $user->id,
        ]);

        MessageEvent::broadcast($conversation, $message);

        return response()->noContent();
    }
}
