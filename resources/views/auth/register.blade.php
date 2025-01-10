@extends('layouts.master')

@section('content')
    <div class="bg-light p-4 mx-auto" style="max-width: 800px;">
        <div class="d-flex justify-content-center">
            <img src="assets/img/logo.png" alt="Logo" style="width: 100px; height: 100px; margin-right: 8px;">
        </div>
        
        <h2 class="text-center my-5">@lang('lang.title_register')</h2>
        
        @if ($errors->any() || session()->has('error'))
            <div class="bg-danger p-3 text-white mb-3 d-flex align-items-center justify-content-between" id="errorMsg">
                <span>{{ session('error') ?? $errors->first() }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" id="closeError"
                    fill="#e8eaed" style="cursor: pointer">
                    <path
                        d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                </svg>
            </div>
        @endif

        <form action="{{ route('postRegister') }}" method="POST" class="d-flex flex-column gap-3">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">@lang('lang.email')</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="connectfriend@gmail.com"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">@lang('lang.name')</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ivan Adrian"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender">@lang('lang.gender')</label>
                        <select class="form-control pe-5" id="gender" name="gender" style="cursor: pointer">
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }} >@lang('lang.male')</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }} >@lang('lang.female')</option>
                        </select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mobile">@lang('lang.mobile_number')</label>
                        <input type="text" class="form-control" id="mobile" name="mobile_number" placeholder="08XXXXXXXXX"
                            value="{{ old('mobile_number') }}">
                        @error('mobile_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="profession">@lang('lang.occupation')</label>
                        <select class="form-control pe-5" id="profession" name="profession" style="cursor: pointer">
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->id }}" {{ old('profession') == $profession->id ? 'selected' : '' }}>
                                    {{ $profession->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('profession')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="linkedin">Linkedin</label>
                        <input type="text" class="form-control" id="linkedin" name="linkedin"
                            placeholder="https://www.linkedin.com/in/username" value="{{ old('linkedin') }}">
                        @error('linkedin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="fields" class="form-label">@lang('lang.field_of_work')</label>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($fields as $field)
                        <div class="form-check">
                            <input type="checkbox" name="fields[]" value="{{ $field->id }}" 
                                class="form-check-input" style="cursor: pointer"
                                {{ in_array($field->id, old('fields', [])) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $field->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('fields')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price">@lang('lang.price')</label>
                <input type="text" disabled class="form-control" id="price" name="price" value="">
            </div>
            <input type="hidden" name="price" id="hidden-price">

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success">@lang('lang.btn_submit')</button>
            </div>
        </form>
        <div class="mt-4">
            <span class="d-flex justify-content-center align-items-center py-2">
                <a href="{{ route('login-page') }}" class="text-decoration-none text-dark">@lang('lang.have_account')</a>
            </span>
            <span class="d-flex justify-content-center align-items-center py-2">
                <a href="{{ route('homepage') }}" class="btn btn-danger btn-sm text-white">@lang('lang.btn_back_home')</a>
            </span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const randomPrice = Math.floor(Math.random() * (125000 - 100000 + 1)) + 100000;

            document.getElementById('price').value = randomPrice;
            document.getElementById('hidden-price').value = randomPrice;
        });
    </script>
@endsection
