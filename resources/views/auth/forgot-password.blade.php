@extends('customer.main')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <div style="width: 1000px">

        <div class="bg-white rounded-xl p-4">

            <div class="d-flex justify-content-between align-items-center">
                <div class="col-8">
                    <div class="mb-4 text-sm color_dark">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="">
                            <x-input-label class="color_dark" for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                          style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;"
                                          class="block mt-1 w-full"
                                          type="email"
                                          name="email"
                                          :value="old('email')"
                                          required
                                          autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <x-primary-button
                            style="background-color: #6d2932; color: #f5f1e3; font-size: 0.85em !important; font-weight: 500; border-radius: 15px; padding: 8px 25px; text-align: center; display: flex; justify-content: center; align-items: center;"
                            class="btn btn_maroon w-full mt-4">
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </form>
                </div>

                <div class="">
                    <img style="position: relative; top: 28px; width: 300px; !important;" src="/image/hootbert/hootbert_half.png" alt="Forgot Password Image">
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
