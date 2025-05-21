@extends('customer.main')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <div style="width: 1000px">

        <div class="bg-white rounded-xl p-4">

            <div class="d-flex justify-content-between align-items-center">
                <div class="col-8">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                    
                        <!-- Email Address -->
                        <div class="">
                            <x-input-label class="color_dark" for="email" :value="__('Email')" />
                            <x-text-input id="email" 
                                        class="block mt-1 w-full bg_form text-black" 
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
                                        autofocus 
                                        autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label class="color_dark" for="password" :value="__('Password')" />
                            <x-text-input id="password" 
                                        class="block mt-1 w-full bg_form text-black"
                                        type="password"
                                        name="password"
                                        required 
                                        autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    
                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded-xl" name="remember">
                                <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <x-primary-button class="btn btn_maroon w-full mt-4">
                                {{ __('Log in') }}
                        </x-primary-button>
                        <div class="mt-2">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm color_dark" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                    </form>
                </div>

                <div class="">
                    <img style="position: relative; top: 28px; width: 300px; !important;" src="/image/hootbert/hootbert_half.png" alt="Mulai jualan">
                </div>
            </div>

        </div>

    </div>
</div>
