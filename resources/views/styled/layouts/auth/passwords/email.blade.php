@extends('layout.layout')

@section('content')
    <div class="w-full h-full grid place-item-center p-[10%]">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card min-w-[300px] max-w-[70%] mx-auto shadow-lg">
                    <div class="card-header text-2xl text-black font-bold uppercase p-3">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-3">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror w-[80%] mx-auto"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 flex justify-center gap-3">
                                    <button type="submit" class="btn bg-violet-800 hover:bg-violet-400 text-white">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
