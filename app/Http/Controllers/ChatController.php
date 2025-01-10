<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $friends = Friend::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('friend_id', $user->id);
        })
        ->where('status', 'accepted')
        ->get();

        $notifications = Notification::latest()
            ->where('user_id', $user->id)
            ->get();

        return view('pages.message', compact('notifications', 'friends'));
    }

    public function getMessages($friendId)
    {
        $userId = Auth::user()->id;

        $messages = Message::where(function ($query) use ($userId, $friendId) {
            $query->where('sender_id', $userId)->where('receiver_id', $friendId);
        })
        ->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('sender_id', $friendId)->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json(compact('messages'));
    }


    public function sendMessages(Request $request, $friendId)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);
        $content = $validated['content'];
        $senderId = Auth::user()->id;
    
        Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $friendId,
            'content' => $content,
        ]);
    
        Notification::create([
            'user_id' => $friendId,
            'sender_id' => $senderId,
            'content' => $content,
            'type' => 'message',
        ]);
    
        $messages = Message::whereIn('sender_id', [$senderId, $friendId])
            ->whereIn('receiver_id', [$senderId, $friendId])
            ->orderBy('created_at', 'asc')
            ->get();
    
        return response()->json(compact('messages'));
    }
    
}
