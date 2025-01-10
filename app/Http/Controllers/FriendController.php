<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = Friend::where('user_id', $user->id)
                         ->orWhere('friend_id', $user->id)
                         ->get();

        $notifications = Notification::latest()->where('user_id', $user->id)->get();

        return view('pages.friends', compact('friends', 'notifications'));
    }

    public function addFriend($userId)
    {
        $authUser = Auth::user();
        $userToAdd = User::findOrFail($userId);

        [$userId, $friendId] = $authUser->id < $userToAdd->id ? [$authUser->id, $userToAdd->id] : [$userToAdd->id, $authUser->id];

        $existingFriendship = Friend::where(['user_id' => $userId, 'friend_id' => $friendId])->exists();

        if ($existingFriendship) {
            Friend::where(['user_id' => $userId, 'friend_id' => $friendId])
                ->update(['status' => 'accepted']);
        } else {
            Friend::create([
                'user_id' => $userId,
                'friend_id' => $friendId,
                'status' => 'pending',
                'sender_id' => $authUser->id,
            ]);

            Notification::create([
                'user_id' => $userToAdd->id,
                'sender_id' => $authUser->id,
                'content' => "Friend request from {$authUser->name}",
                'type' => 'friend_request',
            ]);
        }

        return back()->with('message', 'Friend request sent!');
    }

    public function removeFriend($userId)
    {
        $authUser = Auth::user();

        $friend = Friend::where([
                ['user_id', $authUser->id],
                ['friend_id', $userId]
            ])
            ->orWhere([
                ['user_id', $userId],
                ['friend_id', $authUser->id]
            ])
            ->first();

        if ($friend) {
            $friend->delete();
            return back()->with('message', 'Friend removed!');
        }

        return back()->with('message', 'No friendship found!');
    }

    public function acceptFriend($userId)
    {
        $authUser = Auth::user();

        $friendship = Friend::where(function($query) use ($userId, $authUser) {
            $query->where('user_id', $userId)
                  ->where('friend_id', $authUser->id)
                  ->where('status', 'pending');
        })
        ->orWhere(function($query) use ($userId, $authUser) {
            $query->where('user_id', $authUser->id)
                  ->where('friend_id', $userId)
                  ->where('status', 'pending'); 
        })
        ->first();

        if ($friendship) {
            $friendship->update(['status' => 'accepted']);

            Notification::where([
                ['user_id', $authUser->id],
                ['sender_id', $userId],
                ['type', 'friend_request']
            ])->delete();

            return back()->with('message', 'Friend request accepted!');
        }

        return back()->with('error', 'Friend request not found or already accepted!');
    }

    public function rejectFriend($userId)
    {
        $authUser = Auth::user();

        $friendship = Friend::where(function($query) use ($userId, $authUser) {
            $query->where('user_id', $userId)
                  ->where('friend_id', $authUser->id)
                  ->where('status', 'pending'); 
        })
        ->orWhere(function($query) use ($userId, $authUser) {
            $query->where('user_id', $authUser->id)
                  ->where('friend_id', $userId)
                  ->where('status', 'pending'); 
        })
        ->first();

        if ($friendship) {
            $friendship->delete();

            Notification::where([
                ['user_id', $authUser->id],
                ['sender_id', $userId],
                ['type', 'friend_request']
            ])->delete();

            return back()->with('message', 'Friend request rejected!');
        }

        return back()->with('error', 'Friend request not found!');
    }
}
