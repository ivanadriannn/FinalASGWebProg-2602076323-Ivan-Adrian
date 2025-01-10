@extends('layouts.master')

@section('content')
    @include('components.landing')
    <div class="d-flex align-items-center justify-content-start gap-3 mb-5">
        <form action="" method="GET" class="d-flex align-items-center gap-2 w-100">
            <div class="input-group" style="max-width: 400px;">
                <input class="form-control form-control-sm border-2 border-secondary rounded-start-2" 
                       type="text" name="search" 
                       placeholder="@lang('lang.search')" 
                       value="{{ request('search') }}" 
                       style="height: 50px;">
                <button type="submit" class="btn btn-success rounded-end-2" style="height: 50px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1.007 1.007 0 0 0-.115-.098zm-5.482.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                    </svg>
                </button>
            </div>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" 
                        type="button" id="genderDropdown" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    @lang('lang.filter_by_gender')
                </button>
                <ul class="dropdown-menu" aria-labelledby="genderDropdown">
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   value="male" id="genderMale" name="gender[]" 
                                   {{ in_array('male', request('gender', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="genderMale">@lang('lang.male')</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   value="female" id="genderFemale" name="gender[]" 
                                   {{ in_array('female', request('gender', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="genderFemale">@lang('lang.female')</label>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" 
                        type="button" id="fieldDropdown" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    @lang('lang.filter_by_field_of_work')
                </button>
                <ul class="dropdown-menu" aria-labelledby="fieldDropdown">
                    @foreach ($fields as $field)
                        <li>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       value="{{ $field->name }}" id="field{{ $field->id }}" name="field[]" 
                                       {{ in_array($field->name, request('field', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="field{{ $field->id }}">{{ $field->name }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <button type="submit" class="btn btn-success btn-sm">
                @lang('lang.btn_apply_filter')
            </button>
        </form>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($users as $u)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <img src="{{ $u->profile_image ? 'data:image/jpeg;base64,' . base64_encode($u->profile_image) : asset('assets/img/profile.png') }}"
                            class="rounded-circle mb-3" alt="@lang('lang.profile_image')"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="card-title text-primary">{{ Str::limit($u->name, 18, '...') }}</h5>
                        <p class="card-text text-muted">{{ $u->profession->name }}</p>
                        @foreach ($u->userFields as $uf)
                            <small class="d-block text-muted">{{ $uf->fieldOfWork->name }}</small>
                        @endforeach

                        @auth
                            @if ($u->id != auth()->user()->id)
                                @if (
                                    $friends->contains(function ($friend) use ($u) {
                                        return ($friend->user_id == $u->id || $friend->friend_id == $u->id) && $friend->status == 'accepted';
                                    }))
                                    <form action="{{ route('remove-friends', $u->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                            <i class="fa-solid fa-user-minus me-1"></i>@lang('lang.status_remove')
                                        </button>
                                    </form>
                                @elseif (
                                    $friends->contains(function ($friend) use ($u) {
                                        return ($friend->user_id == $u->id || $friend->friend_id == $u->id) &&
                                            $friend->status == 'pending' &&
                                            $friend->sender_id == Auth::user()->id;
                                    }))
                                    <button class="btn btn-warning btn-sm w-100 mt-3" disabled>
                                        <i class="fa-regular fa-clock me-1"></i>@lang('lang.status_pending')
                                    </button>
                                @else
                                    <form action="{{ route('add-friends', $u->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm w-100">
                                            <i class="fa-regular fa-thumbs-up me-1"></i>@lang('lang.add_friend')
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login-page') }}" class="btn btn-success btn-sm w-100 mt-3">
                                <i class="fa-regular fa-thumbs-up me-1"></i>@lang('lang.add_friend')
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
@endsection
