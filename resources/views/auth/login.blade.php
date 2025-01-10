@extends('layouts.master')

@section('content')
    <div class="bg-light p-4 mx-auto" style="max-width: 350px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);">
        <div class="d-flex justify-content-center">
            <img src="assets/img/logo.png" alt="Logo" style="width: 100px; height: 100px; margin-right: 8px;">
        </div>
        <h2 class="text-center my-5 text-dark">@lang('lang.title_login')</h2>
        @if ($errors->any() || session()->has('error'))
            <div class="bg-danger p-3 text-white mb-3 d-flex align-items-center justify-content-between rounded">
                <span>{{ session('error') ?? $errors->first() }}</span>
            </div>
        @endif
        <form action="{{ route('postLogin') }}" method="POST" class="d-flex flex-column gap-4">
            @csrf
            <div class="form-group">
                <label for="email" class="text-dark">@lang('lang.email')</label>
                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" placeholder="@lang('lang.ex_email')" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="text-dark">@lang('lang.password')</label>
                <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" placeholder="@lang('lang.ex_password')" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success btn-lg w-100">@lang('lang.btn_submit')</button>
            </div>
        </form>
        <div class="mt-4">
            <span class="d-flex justify-content-center align-items-center py-2">
                <a href="{{ route('register-page') }}" class="text-decoration-none text-dark">@lang('lang.dont_have_account')</a>
            </span>
            <span class="d-flex justify-content-center align-items-center py-2">
                <a href="{{ route('homepage') }}" class="btn btn-danger btn-sm text-white">@lang('lang.btn_back_home')</a>
            </span>
        </div>
    </div>
@endsection
