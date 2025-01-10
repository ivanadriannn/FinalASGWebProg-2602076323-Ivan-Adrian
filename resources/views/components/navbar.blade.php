<nav class="navbar navbar-expand-lg bg-success">
    <div class="container-fluid mx-auto px-4 d-flex" style="max-width: 1200px; justify-content: space-between">
        <a class="navbar-brand text-light fw-bold d-flex align-items-center" href="{{ route('homepage') }}">
            <img src="assets/img/logo.png" alt="Logo" style="width: 30px; height: 30px; margin-right: 8px;">
            ConnectFriend
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto d-flex align-items-center" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('homepage') }}">@lang('lang.nav_home')</a>
                </li>
                
                @if(Auth::check()) 
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('friends') }}">@lang('lang.nav_friends')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('topup') }}">@lang('lang.nav_top_up')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('chat') }}">
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M4 3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h1v2a1 1 0 0 0 1.707.707L9.414 13H15a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4Z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M8.023 17.215c.033-.03.066-.062.098-.094L10.243 15H15a3 3 0 0 0 3-3V8h2a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-1v2a1 1 0 0 1-1.707.707L14.586 18H9a1 1 0 0 1-.977-.785Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" id="navbarLanguageToggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <ul class="dropdown-menu bg-white" aria-labelledby="navbarLanguageToggle">
                        <li>
                            <a href="{{ route('set-locale', 'en') }}" class="dropdown-item text-black">EN</a>
                        </li>
                        <li>
                            <a href="{{ route('set-locale', 'id') }}" class="dropdown-item text-black">ID</a>
                        </li>
                    </ul>
                </li>

                @if(Auth::check())
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarNotificationToggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 1 0 0-4 2 2 0 0 0 0 4zM5.5 14a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5h-6a.5.5 0 0 1-.5-.5zM8 1a4 4 0 0 0-4 4c0 2.64-1.62 4.84-2.5 5.9-.58.54-.9 1.28-.9 2.1V13h12V10.99c0-.82-.32-1.56-.9-2.1C12.62 9.84 11 7.64 11 5a4 4 0 0 0-4-4z"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu scrollbar-hidden" style="max-height: 400px; overflow-y: auto;">
                            @forelse ($notifications as $notification)
                                @if ($notification->type == 'friend_request')
                                    <li>
                                    <a class="dropdown-item d-flex gap-2" 
                                        href="{{ route('friends') }}">
                                            <img src="{{ $notification->sender->profile_image 
                                                        ? 'data:image/jpeg;base64,' . base64_encode($notification->sender->profile_image) 
                                                        : asset('assets/img/profile.png') }}" 
                                                alt="Profile Image" 
                                                style="width: 50px; height: 50px; padding: 5px; object-fit: scale-down; object-position: top">
                                            <div class="d-flex flex-column gap-0">
                                                <p class="mb-0">{{ $notification->sender->name }}</p>
                                                <p class="mb-0">@lang('lang.request_notif')</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item d-flex gap-2" href="{{ route('chat') }}">
                                            <img src="{{ $notification->sender->profile_image ? 'data:image/jpeg;base64,' . base64_encode($notification->sender->profile_image) : asset('assets/img/profile.png') }}"
                                                alt=""
                                                style="width: 50px; height: 50px; padding: 5px; object-fit: scale-down; object-position: top">
                                            <div class="d-flex flex-column gap-0">
                                                <p class="mb-0">{{ $notification->sender->name }}</p>
                                                <p class="mb-0">{{ Str::limit($notification->content, 20, '...') }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif
                            @empty
                                <li>
                                    <p class="dropdown-item mb-0">@lang('lang.no_notification')</p>
                                </li>
                            @endforelse
                        </ul>
                    </li>
                @endif

                @if(Auth::check()) 
                    <li class="nav-item">
                        <a href="{{ route('topup') }}" class="nav-link d-flex align-items-center text-light">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-coin"
                                viewBox="0 0 16 16" width="20" height="20">
                                <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z" />
                                <path d="M8 4.5a.5.5 0 0 1 .5.5v1a2 2 0 1 0 0 4v1a.5.5 0 0 1-1 0v-1a2 2 0 1 0 0-4v-1a.5.5 0 0 1 .5-.5z" />
                            </svg>
                            <span class="ms-2">{{ Auth::user()->coins }}</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-light" href="#"
                            id="navbarProfileToggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_image ? 
                                'data:image/jpeg;base64,' . base64_encode(Auth::user()->profile_image) : 
                                asset('assets/img/profile.png') }}" 
                                alt="Profile" 
                                style="width: 30px; height: 30px; border-radius: 100%; object-fit: cover;">
                            <span class="ms-2">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu bg-white" aria-labelledby="navbarProfileToggle">
                            <li>
                                <a href="{{ route('profile') }}" class="dropdown-item text-black">
                                    @lang('lang.drop_view_profile')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item text-black">
                                    @lang('lang.btn_logout')
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('login-page') }}">@lang('lang.nav_login')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('register-page') }}">@lang('lang.nav_register')</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

