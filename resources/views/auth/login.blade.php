@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-full mx-4 md:mx-0 md:w-96 bg-blue-900 rounded-lg shadow-xl p-6">

        <Logo></Logo>

        <h1 class="text-white text-3xl pt-8">Welcome Back</h1>
        <h2 class="text-blue-300 text-sm font-thin">Enter your credentials below</h2>

        <form method="POST" action="{{ route('login') }}" class="pt-8">
            @csrf

            <div class="relative">
                <label for="email" class="uppercase text-xs font-bold text-blue-500 absolute pl-3 pt-2">{{ __('E-Mail Address') }}</label>

                <div class="">
                    <input
                    id="email"
                    type="email       "
                    class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none focus:bg-blue-700"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="your@email.com"
                    autocomplete="email"
                    autofocus>

                    @error('email')
                        <span class="pt-1 text-red-600 text-xs font-medium" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="relative mt-3">
                <label for="password" class="uppercase text-xs font-bold text-blue-500 absolute pt-2 pl-3">{{ __('Password') }}</label>

                <div class="">
                    <input
                        id="password"
                        type="password"
                        class="w-full bg-blue-800 text-gray-100 pt-8 p-3 rounded outline-none focus:bg-blue-700 "
                        name="password"
                        placeholder="Password"
                        required
                        autocomplete="current-password">

                    @error('password')
                        <span class="pt-1 text-red-600 text-xs font-medium" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="pt-2">
                <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="text-white font-hairline" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <button type="submit" class="uppercase rounded text-blue-800 font-bold mt-8 w-full bg-gray-400 py-2 px-3 text-left focus:outline-none focus:shadow-outline">
                {{ __('Login') }}
            </button>

            <div class="flex justify-between pt-8 text-white text-sm font-bold">

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                @endif

            </div>

        </form>

    </div>
</div>
@endsection
