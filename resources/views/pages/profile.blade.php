@extends('layouts.master')

@section('content')
<style>
    @media (max-width: 640px) {
        .profile-container {
            flex-direction: column;
            align-items: center;
        }
    }

    .profile-container {
        max-width: 800px;
        margin: auto;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-header img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .table {
        margin-top: 10px;
        width: 100%;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
    }

    .table th, .table td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .table th {
        background: #f1f1f1;
        font-weight: bold;
    }

    .toggle-container {
        margin: 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .toggle-container p {
        margin: 0;
        font-weight: bold;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 25px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #007bff;
    }

    input:checked + .slider:before {
        transform: translateX(25px);
    }

    .avatar-card img {
        width: 100px;
        height: 100px;
        object-fit: contain;
        border-radius: 50%;
        border: 2px solid #ddd;
    }

    .avatar-card .card-body {
        display: flex;
        justify-content: center;
        gap: 8px;
        align-items: center;
    }

</style>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="profile-container">
    <div class="profile-header">
        <h3>{{ $user->name }}</h3>
        <p>{{ $user->email }}</p>
        <img src="{{ $user->profile_image ? 'data:image/jpeg;base64,' . base64_encode($user->profile_image) : asset('assets/img/profile.png') }}"
                alt="Profile Image"
                style="width: 150px; height: 150px; padding: 10px; object-fit: scale-down; object-position: top">
    </div>

    <div>
        <table class="table" style="background-color: rgb(159, 221, 174); border: 1px solid #9fddae;">
            <tr>
                <th style="border: 1px solid #9fddae; background-color: rgb(159, 221, 174);">@lang('lang.occupation')</th>
                <td style="border: 1px solid #9fddae;">{{ $user->profession->name ?? '-' }}</td>
            </tr>
            <tr>
                <th style="border: 1px solid #9fddae; background-color: rgb(159, 221, 174);">@lang('lang.gender')</th>
                <td style="border: 1px solid #9fddae;">{{ $user->gender ?? '-' }}</td>
            </tr>
            <tr>
                <th style="border: 1px solid #9fddae; background-color: rgb(159, 221, 174);">@lang('lang.field_of_work')</th>
                <td style="border: 1px solid #9fddae;">
                    @if ($user->userFields)
                        @foreach ($user->userFields as $uf)
                            {{ $uf->fieldOfWork->name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    @else
                        - 
                    @endif
                </td>
            </tr>
            <tr>
                <th style="border: 1px solid #9fddae; background-color: rgb(159, 221, 174);">LinkedIn</th>
                <td style="border: 1px solid #9fddae;"><a href="{{ $user->linkedin }}">{{ $user->linkedin }}</a></td>
            </tr>
        </table>
    </div>


    <div class="mb-4">
        <div class="toggle-container mb-3">
            <p>@lang('lang.profile_visibility')</p>
            <form method="POST" action="{{ $user->is_visible ? route('invisible-profile') : route('visible-profile') }}">
                @csrf
                <label class="switch">
                    <input type="checkbox" name="profile_visibility" {{ $user->is_visible ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="slider round"></span>
                </label>
            </form>
        </div>

        <div class="mt-4">
            <h3 class="text-center">Buy a New Avatar</h3>
            <h6>@lang('lang.your_coin'): {{ $user->coins }}</h6>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($avatars as $avatar)
                    @if ($avatar->id > 3)
                        <a href="{{ route('bought-avatar', ['avatar_id' => $avatar->id]) }}" class="col text-decoration-none">
                            <div class="card avatar-card text-center p-3 border-0 shadow-sm" style="background-color:rgb(207, 236, 214); color: white;">
                                <div class="card-body d-flex justify-content-center align-items-center gap-2">
                                    <img src="data:image/jpeg;base64,{{ base64_encode($avatar->image) }}" alt="Avatar Image" class="card-img-top" style="border: none;">
                                </div>
                                <div class="card-body d-flex align-items-center justify-content-center flex-column gap-1">
                                    <p class="card-text fw-bold mb-0" style="color: black;">{{ $avatar->price }} @lang('lang.coin')</p>
                                    
                                    @if ($transactions->contains('avatar_id', $avatar->id))
                                        <p class="card-text fw-bold text-success mb-0">(@lang('lang.bought'))</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('logout') }}" class="btn btn-danger">@lang('lang.btn_logout')</a>
        </div>
    </div>
</div>
@endsection
