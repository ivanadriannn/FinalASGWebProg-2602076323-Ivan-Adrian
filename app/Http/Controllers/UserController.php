<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FieldOfWork;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\Profession;
use App\Models\User;
use App\Models\UserField;
use App\Models\Avatar;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        session()->forget('register_data');

        $searchQuery = request('search');
        $genderFilters = request('gender', []);
        $fieldFilters = request('field', []);

        $usersQuery = User::query()->where('is_visible', 1);

        if (Auth::check()) {
            $usersQuery->where('id', '!=', Auth::id());
        }

        $this->applySearchFilter($usersQuery, $searchQuery);

        if (!empty($genderFilters)) {
            $usersQuery->whereIn('gender', $genderFilters);
        }

        if (!empty($fieldFilters)) {
            $this->applyFieldFilter($usersQuery, $fieldFilters);
        }

        $users = $usersQuery->paginate(8)->appends([
            'search' => $searchQuery,
            'gender' => $genderFilters,
            'field' => $fieldFilters,
        ]);

        $fields = FieldOfWork::all();

        if (Auth::check()) {
            $data = $this->getUserDataForAuthenticatedUser($users, $fields);
        } else {
            $data = compact('users', 'fields');
        }

        return view('pages.homepage', $data);
    }

    private function applySearchFilter($query, $searchQuery)
    {
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('gender', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('profession', function ($q) use ($searchQuery) {
                        $q->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('userFields', function ($q) use ($searchQuery) {
                        $q->whereHas('fieldOfWork', function ($q) use ($searchQuery) {
                            $q->where('name', 'like', '%' . $searchQuery . '%');
                        });
                    });
            });
        }
    }

    private function applyFieldFilter($query, $fieldFilters)
    {
        $query->whereHas('userFields', function ($q) use ($fieldFilters) {
            $q->whereHas('fieldOfWork', function ($q) use ($fieldFilters) {
                $q->whereIn('name', $fieldFilters);
            });
        });
    }

    private function getUserDataForAuthenticatedUser($users, $fields)
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $friends = Friend::where('user_id', $user->id)
            ->orWhere('friend_id', $user->id)
            ->get()
            ->unique();

        return compact('users', 'fields', 'notifications', 'friends');
    }

    public function login()
    {
        session()->forget('register_data');

        return view('auth.login');
    }

    public function register()
    {
        session()->forget('register_data');

        $fields = FieldOfWork::get();
        $professions = Profession::get();

        return view('auth.register', compact('fields', 'professions'));
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => __('lang.email_required'),
            'email.email' => __('lang.notvalid_email'),
            'password.required' => __('lang.password_required'),
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Auth::login($user);
            return redirect()->route('homepage');
        }

        return redirect()->route('login-page')->with('error', __('lang.failed_to_login'));
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users|email',
            'name' => 'required',
            'gender' => 'required',
            'fields' => 'required|array|min:3',
            'profession' => 'required',
            'linkedin' => 'required',
            'mobile_number' => 'required|numeric',
            'password' => 'required',
        ], [
           'email.required' => __('lang.email_required'),
            'email.unique' => __('lang.unique_email'),
            'email.email' => __('lang.notvalid_email'),
            'name.required' => __('lang.name_required'),
            'gender.required' => __('lang.gender_required'),
            'fields.required' => __('lang.fields_required'),
            'fields.min' => __('lang.field_minimum'),
            'profession.required' => __('lang.profession_required'),
            'linkedin.required' => __('lang.linkedin_required'),
            'mobile_number.required' => __('lang.mobile_number_required'),
            'mobile_number.numeric' => __('lang.number_numeric'),
            'password.required' => __('lang.password_required'),
        ]);

        session()->put('register_data', $request->all());

        return redirect()->route('payment');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }
}
