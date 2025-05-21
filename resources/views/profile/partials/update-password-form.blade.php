<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label style="font-weight: 400 !important; font-size: 0.85em !important; padding: 0; margin: 0;" class="color_dark" for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg_form" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label style="font-weight: 400 !important; font-size: 0.85em !important; padding: 0; margin: 0;" class="color_dark" for="update_password_password" :value="__('New Password')" />
            <x-text-input style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;" id="update_password_password" name="password" type="password" class="mt-1 block w-full bg_form" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label style="font-weight: 400 !important; font-size: 0.85em !important; padding: 0; margin: 0;" class="color_dark" for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input style="background: #f0f0f0; border-radius: 10px; padding: 10px 10px; font-size: 0.85em !important; color: #202020; border: #e0e0e0 1px solid;" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg_form" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button class="btn btn_maroon">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
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
