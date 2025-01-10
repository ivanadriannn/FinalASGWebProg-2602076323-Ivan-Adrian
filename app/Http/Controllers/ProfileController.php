<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\User;
use App\Models\Avatar;
use App\Models\Transaction;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();
        $avatars = Avatar::all();

        $a = Friend::where('user_id', $user->id)
            ->where('status', 'accepted');

        $b = Friend::where('friend_id', $user->id)
            ->where('status', 'accepted');

        $notifications = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        $transactions = Transaction::where('user_id', $user->id)->get();

        if ($request->has('avatar_id')) {
            $avatarId = $request->input('avatar_id');
            $avatar = Avatar::find($avatarId);

            if (!$avatar) {
                return redirect()->route('profile')->with('error', 'Avatar not found.');
            }

            $transactionExists = Transaction::where('user_id', $user->id)
                ->where('avatar_id', $avatarId)
                ->exists();

            if ($transactionExists) {
                $user->profile_image = $avatar->image;
                $user->save();
                return redirect()->route('profile')->with('success', __('lang.profile_updated'));
            }

            if ($user->coins < $avatar->price) {
                return redirect()->route('profile')->with('error', __('lang.not_enough_coins'));
            }

            $user->coins -= $avatar->price;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'avatar_id' => $avatarId,
            ]);

            $user->profile_image = $avatar->image;
            $user->save();

            return redirect()->route('profile')->with('success', __('lang.avatar_purchased'));
        }
        
        return view('pages.profile', compact('user', 'notifications', 'avatars', 'transactions'));
    }

    public function invisibleProfile()
    {
        $user = Auth::user();

        $cost = 50;

        if ($user->coins < $cost) {
            return back()->with('error', __('lang.insuffcient_to_remove'));
        }

        $user->decrement('coins', $cost);

        $bearAvatar = Avatar::whereBetween('id', [1, 3])->inRandomOrder()->first();

        $user->update([
            'profile_image' => $bearAvatar->image,
            'is_visible' => false,
        ]);

        return back()->with('success', __('lang.profile_invisible'));
    }

    public function visibleProfile()
    {
        $user = Auth::user();
        $cost = 5;

        if ($user->coins < $cost) {
            return back()->with('error', __('lang.insuffcient_to_remove'));
        }

        $user->decrement('coins', $cost);

        $user->update([
            'is_visible' => true,
            'profile_image' => null,
        ]);

        return back()->with('success', __('lang.profile_visible'));
    }

    public function updateProfileImages()
    {
        $friends = Friend::all();
        return response()->json($friends->map(function ($friend) {
            return [
                'id' => $friend->id,
                'image' => $friend->profile_image
                    ? 'data:image/jpeg;base64,' . base64_encode($friend->profile_image)
                    : asset('assets/img/profile.png'),
            ];
        }));
    }
}
