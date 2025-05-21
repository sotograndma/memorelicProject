@extends('customer.main')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <div style="width: 1000px">

        <div class="bg-white rounded-xl p-4">

            <div class="d-flex justify-content-between align-items-center">
                <div class="col-8">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="">
                            <x-input-label class="color_dark" for="name" :value="__('Name')" />
                            <x-text-input id="name"
                                style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;"
                                class="block mt-1 w-full"
                                type="text"
                                name="name"
                                :value="old('name')"
                                required
                                autofocus
                                autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mt-4">
                            <x-input-label class="color_dark" for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;"
                                class="block mt-1 w-full"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label class="color_dark" for="password" :value="__('Password')" />
                            <x-text-input id="password"
                                style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;"
                                class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label class="color_dark" for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation"
                                style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;"
                                class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <x-primary-button style="background-color: #6d2932; color: #f5f1e3; font-size: 0.85em !important; font-weight: 500; border-radius: 15px; padding: 8px 25px 8px 25px;text-align: center !important;  display: flex; justify-content: center; align-items: center;" class="w-full mt-4">
                            {{ __('Register') }}
                        </x-primary-button>

                        <div class="text-sm mt-2">
                            <a class="underline color_dark" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                        </div>
                    </form>
                </div>

                <div class="">
                    <img style="position: relative; top: 89px; width: 300px; !important;" src="/image/hootbert/hootbert_half.png" alt="Register Image">
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
