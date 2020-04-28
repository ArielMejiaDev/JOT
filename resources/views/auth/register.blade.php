@extends('layouts.app')

@section('content')
<div class="mx-auto h-full bg-gray-300 flex justify-center items-center">
    <div class="w-96 mx-4 md:mx-0 bg-blue-900 rounded-lg shadow-xl p-6">

        <Logo></Logo>

        <h1 class="text-white text-3xl pt-8 font-light">Join us</h1>
        <h2 class="text-blue-300 text-sm font-bold">Enter your information below</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="relative">
                <label for="name" class="absolute text-xs font-bold uppercase text-blue-500 pt-2 pl-3">{{ __('Name') }}</label>

                <div class="mt-8">
                    <input
                        id="name"
                        type="text"
                        class="pt-8 p-3 w-full bg-blue-800 focus:bg-blue-700 rounded outline-none text-gray-100"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Your name"
                        autocomplete="name"
                        autofocus>

                    @error('name')
                        <span class="pt-1 text-red-600 text-xs font-medium" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="relative mt-3">

                <label for="email" class="absolute text-blue-500 uppercase font-bold text-xs pt-2 pl-3">{{ __('E-Mail Address') }}</label>

                <div class="">
                    <input
                        id="email"
                        type="text"
                        class="pt-8 p-3 w-full rounded bg-blue-800 focus:bg-blue-700 outline-none text-gray-100"
                        name="email"
                        placeholder="your@email.com"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email">

                    @error('email')
                        <span class="pt-1 text-red-600 text-xs font-medium" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="relative mt-3">
                <label for="password" class="absolute uppercase text-blue-500 font-bold text-xs pt-2 pl-3">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input
                        id="password"
                        type="password"
                        class="pt-8 p-3 w-full rounded bg-blue-800 focus:bg-blue-700 outline-none text-gray-100"
                        name="password"
                        placeholder="Password"
                        required
                        autocomplete="new-password">

                    @error('password')
                        <span class="pt-1 text-red-600 text-xs font-medium" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="relative mt-3">
                <label for="password-confirm" class="absolute uppercase text-xs text-blue-500 font-bold pt-2 pl-3">{{ __('Confirm Password') }}</label>

                <div class="">
                    <input
                        id="password-confirm"
                        type="password"
                        class="pt-8 p-3 w-full rounded bg-blue-800 focus:bg-blue-700 outline-none text-gray-100"
                        name="password_confirmation"
                        required
                        autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="mt-8 w-full bg-gray-400 uppercase rounded text-blue-800 font-bold py-2 px-3 text-left focus:outline-none focus:shadow-outline">
                {{ __('Register') }}
            </button>

            <div class="flex justify-between items-center text-white font-bold text-sm mt-8">
                <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                <a href="/login">{{ __('Login') }}</a>
            </div>

        </form>

    </div>
</div>
@endsection
