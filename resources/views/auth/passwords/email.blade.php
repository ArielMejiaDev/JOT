@extends('layouts.app')

@section('content')

<div class="mx-auto h-full bg-gray-300 flex justify-center items-center">

    <div class="w-96 p-6 mx-4 md:mx-0 bg-blue-900 rounded-lg shadow-xl">

        <Logo></Logo>

        <h1 class="mt-8 text-white text-3xl font-light">Oh no!</h1>
        <h2 class="text-blue-300 text-sm font-bold">Enter your email to reset password</h2>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="relative mt-8">

                <label for="email" class="absolute uppercase text-xs text-blue-500 font-bold pt-2 pl-3">{{ __('E-Mail Address') }}</label>

                <div class="">
                    <input id="email" type="email" required class="w-full text-gray-100 rounded bg-blue-800 focus:bg-blue-700 pt-8 p-3 outline-none" placeholder="your@email.com" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                    @error('email')
                        <span class="mt-1 text-red-600 font-medium text-xs" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="mt-8 text-left p-3 w-full bg-gray-400 text-blue-800 rounded uppercase cursor-pointer focus:outline-none focus:shadow-outline">
                {{ __('Send Password Reset Link') }}
            </button>

            <div class="mt-8 flex justify-between items-center text-white text-sm font-bold">
                <a href="/login">{{ __('Login') }}</a>
                <a href="/register">{{ __('Register') }}</a>
            </div>

        </form>

    </div>

</div>
@endsection
