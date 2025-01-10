@extends('layouts.master')

@section('content')
    <div class="bg-light px-3 py-5 mx-auto" style="max-width: 640px">
        <div class="mb-4">
            <h2 class="text-center">@lang('lang.friends_list')</h2>
            <div class="d-flex justify-content-center">
                <img src="{{ asset('assets/img/friend.png') }}" alt="Payment" class="mb-3" style="width: 100px; height: auto;">
            </div>
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" id="pending-tab" data-bs-toggle="pill" href="#pending">@lang('lang.pending_request')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="accepted-tab" data-bs-toggle="pill" href="#accepted">@lang('lang.accepted_friends')</a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="pending">
                <div class="d-flex flex-column gap-3">
                    @forelse ($friends as $friend)
                        @if ($friend->status == 'pending')
                            <div class="d-flex justify-content-between align-items-center gap-3 p-3" style="border: 1px solid #8bc34a; background-color: #e8f5e9; border-radius: 15px;">
                                <div>
                                    <img src="{{ Auth::user()->id == $friend->friend_id
                                        ? (isset($friend->user->profile_image) && !empty($friend->user->profile_image)
                                            ? 'data:image/jpeg;base64,' . base64_encode($friend->user->profile_image)
                                            : asset('assets/img/profile.png'))
                                        : (isset($friend->friend->profile_image) && !empty($friend->friend->profile_image)
                                            ? 'data:image/jpeg;base64,' . base64_encode($friend->friend->profile_image)
                                            : asset('assets/img/profile.png')) }}"
                                        alt=""
                                        style="width: 50px; height: 50px; padding: 5px; object-fit: scale-down; object-position: top" />
                                </div>
                                <div class="d-flex flex-column gap-1 w-75">
                                    <h5 class="mb-0">
                                        @if (Auth::user()->id < $friend->user_id || Auth::user()->id == $friend->friend_id)
                                            {{ $friend->user->name }}
                                        @else
                                            {{ $friend->friend->name }}
                                        @endif
                                    </h5>
                                    <div>
                                        @if (Auth::user()->id != $friend->sender_id)
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('accept-friends', $friend->sender_id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm d-flex align-items-center">
                                                        <i class="fa-regular fa-thumbs-up me-1"></i>  <!-- Ikon thumbs-up Font Awesome -->
                                                        @lang('lang.accept')
                                                    </button>
                                                </form>
                                                <form action="{{ route('reject-friends', $friend->sender_id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">@lang('lang.reject')</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <h5 class="text-center">@lang('lang.no_pending_request')</h5>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="accepted">
                <div class="d-flex flex-column gap-3">
                    @forelse ($friends as $friend)
                        @if ($friend->status == 'accepted')
                            <div class="d-flex justify-content-between align-items-center gap-3 p-3" style="border: 1px solid #8bc34a; background-color: #e8f5e9; border-radius: 15px;">
                                <div>
                                    <img src="{{ Auth::user()->id == $friend->friend_id
                                        ? (isset($friend->user->profile_image) && !empty($friend->user->profile_image)
                                            ? 'data:image/jpeg;base64,' . base64_encode($friend->user->profile_image)
                                            : asset('assets/img/profile.png'))
                                        : (isset($friend->friend->profile_image) && !empty($friend->friend->profile_image)
                                            ? 'data:image/jpeg;base64,' . base64_encode($friend->friend->profile_image)
                                            : asset('assets/img/profile.png')) }}"
                                        alt=""
                                        style="width: 50px; height: 50px; padding: 5px; object-fit: scale-down; object-position: top" />
                                </div>
                                <div class="d-flex flex-column gap-1 w-75">
                                    <h5 class="mb-0">
                                        @if (Auth::user()->id < $friend->user_id || Auth::user()->id == $friend->friend_id)
                                            {{ $friend->user->name }}
                                        @else
                                            {{ $friend->friend->name }}
                                        @endif
                                    </h5>
                                    <div>
                                        <a href="{{ route('chat', ['friend_id' => $friend->sender_id]) }}" class="btn btn-primary btn-sm">@lang('lang.chat')</a>
                                        <form action="{{ route('remove-friends', $friend->friend_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">@lang('lang.status_remove')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        @if($friends->where('status', 'accepted')->isEmpty())
                            <h5 class="text-center">@lang('lang.no_friends_found')</h5>
                        @endif
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
