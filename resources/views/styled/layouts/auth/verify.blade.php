@extends('layout.layout')

@section('content')
    <div class="w-full h-full grid place-item-center p-[10%]">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card min-w-[300px] max-w-[70%] mx-auto shadow-lg">
                    <div class="card-header text-2xl text-black font-bold uppercase p-3">
                        {{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}"
                            class="flex flex-col gap-3">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
