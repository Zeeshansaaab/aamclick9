<x-guest-layout>
    <x-slot name='styles'>
        <style>
            .nk-content-body{
                height: 100vh;
            }
            .nk-block{
                margin-top: 8vh;
            }
        </style>
    </x-slot>
    <div class="w-40 m-auto" style="height: 100%;">
        <div class="nk-block-head my-auto">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title">Thank you for submitting form</h4>
                <div class="nk-block-des text-info">
                    <p>{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </p>
                </div>
            </div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}" data-form="ajax-form" redirect-url="{{route('dashboard')}}">
                @csrf
                <div>
                    <x-primary-button>
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-primary-button class="text-sm btn-sm btn-danger" type="submit">
                    {{ __('Log Out') }}
                </x-primary-button>  
            </form>
        </div>
    </div>
    
</x-guest-layout>
