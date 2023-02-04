<x-guest-layout>
    <!-- Session Status -->
    <div class="card card-bordered m-auto" style="width: 50%; margin-top: 19vh!important;">
        <div class="card-inner card-inner-lg">
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Sign-In</h4>
                    <div class="nk-block-des">
                        <p>Access the {{ config('app.name', 'Laravel') }} using your email and passcode.</p>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <div class="form-label-group">
                        <x-input-label for="email" :value="__('Email')" />
                    </div>
                    <div class="form-control-wrap">
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" tabindex="1" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" tabindex="-1"/>
                    </div>
                </div>
                <!-- Password -->
                <div class="form-group">
                    <div class="form-label-group">
                        <x-input-label for="password" :value="__('Password')"/>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link link-primary link-sm">{{ __('Forgot your password?') }}</a>    
                        @endif
                    </div>
                    <div class="form-control-wrap">
                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
                        <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" 
                                    tabindex="2"
                                    />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    </div>
                </div>
                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <div class="form-group">
                    <x-primary-button>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
            <div class="form-note-s2 text-center pt-4"> New on our platform? 
                <a href="{{ route('register') }}">Create an account</a>
            </div>
        </div>
    </div>
</x-guest-layout>
