@extends('customer.dashboard')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <div style="width: 1000px">
        <div class="bg-white rounded-xl p-4">

            <div>
                <x-slot name="header">
                    <h2 class="">
                        {{ __('Profile') }}
                    </h2>
                </x-slot>
            
                <div class="">
                    <div class="p-4">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
        
                    <div class="p-4">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
        
                    {{-- <div class="p-4">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div> --}}
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection