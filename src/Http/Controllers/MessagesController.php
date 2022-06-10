<?php

namespace MichaelNabil230\LaravelChat\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MichaelNabil230\LaravelChat\Models\Chat;
use MichaelNabil230\LaravelChat\Models\Message;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MessageController
{
    public function allChatsUnreadCount(): int
    {
        $user = auth()->user();

        return $user->chats()
            ->whereIsRead(false)
            ->count();
    }

    public function chatUnreadCount(Chat $chat): int
    {
        $user = auth()->user();

        return Message::query()
            ->whereChatId($chat->getKey())
            ->whereToId($user->getKey())
            ->whereIsRead(false)
            ->count();
    }

    public function read(Chat $chat): bool
    {
        return Message::query()
            ->whereChatId($chat->getKey())
            ->whereIsRead(false)
            ->update(['is_read' => true]);
    }

    public function getContacts(Model $user): Collection
    {
        $user = auth()->user();

        $users = Chat::query()
            ->with('lastMessage')
            ->withCount(['messages as unread_messages' => fn ($query) => $query->whereToId($user->getKey())->whereIsRead(false)])
            ->with(['users' => fn ($query) => $query->where('id', '!=', $user->getKey())])
            ->where(function ($query) use ($user) {
                $query
                    ->where('senderable_type', $user->getKey())
                    ->orWhere('recipientable_type', $user->getKey());
            })
            ->orWhere(function ($query) use ($user) {
                $query
                    ->where('senderable_id', $user->getMorphClass())
                    ->orWhere('recipientable_id', $user->getMorphClass());
            })
            ->orderBy('created_at', 'desc')
            ->groupBy('users.id')
            ->get();

        return $users;
    }

    public function getMessage(Chat $chat): LengthAwarePaginator
    {
        return $chat->messages()->paginate();
    }

    public function sendMessage(Request $request, Chat $chat): Message
    {
        $data = $request->validate([
            'body' => ['required', 'string'],
            'user_receiver_id' => ['required', 'string', 'exists:users,id'],
            'type' => ['required', 'string', 'in:text,image,video,audio'],
            'attachment' => ['nullable', 'file'],
        ]);

        if (in_array($request->type, ['image', 'video', 'audio']) && $request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('chat/messages');
        }

        $userSender = auth()->user();
        $userReceiver = User::find($request->user_receiver_id);

        if (! $chat) {
            $chat = Chat::create([
                'from_id' => $userSender->getKey(),
                'to_id' => $userReceiver->getKey(),
            ]);
        }

        if ($chat->type === 'group') {
            # code...
        }

        if ($chat->type === 'private') {
            # code...
        }

        // TODO: add user to chat
        $data = $data + [
            // 'senderable_id' => $userSender->getKey(),
            // 'senderable_type' => $userSender->getMorphClass(),

            // 'recipientable_id' => $userReceiver->getKey(),
            // 'recipientable_type' => $userReceiver->getMorphClass(),
        ];

        $message = $chat->messages()->create($data);

        return $message;
    }

    public function downloadAttachment(Message $message): StreamedResponse
    {
        if (
            in_array($message->type, ['image', 'video', 'audio']) &&
            $message->attachment &&
            Storage::exists($message->attachment)
        ) {
            return Storage::download($message->attachment);
        }

        abort(404, "Sorry, File does not exist in our server or may have been deleted!");
    }

    public function deleteMessage(Message $message): bool
    {
        return $message->delete();
    }

    public function updateMessage(Request $request, Message $message): bool
    {
        $data = $request->validate([
            'body' => ['required', 'string'],
        ]);

        return $message->update($data);
    }

    public function deleteChat(Chat $chat): bool
    {
        // TODO: Check if user auth is the same as chat owners
        $user = auth()->user();
        // abort_if($user->getKey() == 1, 403);

        return $chat->delete();
    }
}
