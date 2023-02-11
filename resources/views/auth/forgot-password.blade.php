<x-guest-layout>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="card card-bordered">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content" style="width: 40%; margin: auto; margin-top: 60px;">
                    <h5 class="nk-block-title">Reset password</h5>
                    <div class="nk-block-des">
                        <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </p>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('password.email') }}" data-form="ajax-form" class="form-container">
                @csrf
                <div class="form-group">
                    <div class="form-label-group">
                        <x-input-label for="email" :value="__('Email')" />
                    </div>
                    <div class="form-control-wrap">
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="form-group">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
            <div class="form-note-s2 text-center pt-4">
                <a href="{{route('login')}}"><strong>Return to login</strong></a>
            </div>
        </div>
    </div>
</x-guest-layout>
