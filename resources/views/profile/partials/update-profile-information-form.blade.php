<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label style="font-weight: 400 !important; font-size: 0.85em !important; padding: 0; margin: 0;" class="color_dark" for="name" :value="__('Name')" />
            <x-text-input style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;" id="name" name="name" type="text" class="mt-1 block w-full bg_form" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label style="font-weight: 400 !important; font-size: 0.85em !important; padding: 0; margin: 0;" class="color_dark" for="email" :value="__('Email')" />
            <x-text-input style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;" id="email" name="email" type="email" class="mt-1 block w-full bg_form" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Foto Profil -->
        <div class="mb-3">
            <p for="profile_photo">Foto Profil (Opsional)</p>
            <input style="font-size: 0.85em !important;" type="file" class="form-control bg_form" id="profile_photo" name="profile_photo">
            @error('profile_photo')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            @if (Auth::user()->userable && Auth::user()->userable->profile_photo)
                <img class="mt-2 rounded-xl" src="{{ asset('storage/' . Auth::user()->userable->profile_photo) }}" alt="Foto Profil" style="width: 200px;">
            @endif
        </div>

        <!-- Lokasi -->
        <div class="mb-3">
            <p for="locations" >Lokasi (Opsional)</p>
            <textarea class="bg_form form-control" name="locations" id="locations">{{ old('locations', Auth::user()->userable->locations ?? '') }}</textarea>
            @error('locations')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="flex items-center gap-4">
            <button class="btn btn_maroon">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
