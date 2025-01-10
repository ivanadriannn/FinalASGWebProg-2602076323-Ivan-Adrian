@extends('layouts.master')

@section('content')
    <div class="bg-light d-flex flex-column gap-4 p-5 mx-auto" style="max-width: 340px">
        <h1 class="text-center">@lang('lang.topup')</h1>
        
        <div class="d-flex justify-content-center align-items-center gap-3">
            <img src="assets/img/coin.png" alt="Coin" style="width: 100px; height: 100px;" />
        </div>

        <div class="d-flex justify-content-center align-items-center gap-3">
            <h5>@lang('lang.your_coin'): {{ $user->coins }}</h5>
        </div>
        
        <form action="{{ route('add-coin') }}">
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success">@lang('lang.add_coin')</button>
            </div>
        </form>
    </div>
@endsection
