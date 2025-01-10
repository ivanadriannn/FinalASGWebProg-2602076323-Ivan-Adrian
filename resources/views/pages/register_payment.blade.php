@extends('layouts.master')

@section('content')
    <div class="bg-light p-4 mx-auto" style="max-width: 480px;">
        <h2 class="text-center my-5">@lang('lang.title_register_payment')</h2>
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/payment.png') }}" alt="Payment Logo" style="max-width: 100px;">
        </div>
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
        <form action="{{ route('postPayment') }}" method="POST" class="d-flex flex-column gap-3">
            @csrf
            <div class="form-group">
                <label for="price">@lang('lang.registration_price')</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ $price }}" disabled>
            </div>
            <input type="hidden" name="price" id="hidden-price" value="{{ $price }}">
            <div class="form-group">
                <label for="payment">@lang('lang.input_registration_price')</label>
                <input type="number" class="form-control" id="payment" name="payment" placeholder="100000">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success">@lang('lang.btn_submit')</button>
            </div>
        </form>
    </div>
    @if (session()->has('overpaid'))
        <div class="modal fade show" id="overpaidModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('lang.title_register_payment')</h5>
                    </div>
                    <div class="modal-body">
                        @lang('lang.overpaid_message', ['amount' => session('amount')])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('lang.no')</button>
                        <form action="{{ route('coins-overpaid') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="{{ session('amount') }}">
                            <button type="submit" class="btn btn-success">@lang('lang.yes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const overpaidModal = document.getElementById('overpaidModal');

            if (overpaidModal) {
                const modal = new bootstrap.Modal(overpaidModal);
                modal.show();
            }
        });
    </script>
@endsection
