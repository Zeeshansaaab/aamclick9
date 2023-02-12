<x-guest-layout>
    <x-slot name="styles">
        <style>
            .nk-wrap-nosidebar .nk-content{
                min-height: auto!important;
            }
        </style>
    </x-slot>
    <form method="POST" action="{{ route('register') }}" data-form="ajax-form" data-redirect-url="{{route('dashboard')}}" class="form-container">
        @csrf
        <div class="row">
            <div class="col-md-6 mt-3">
                <!-- Name -->
                <div class="form-group">
                    <div class="form-label-group">
                        <x-input-label for="name" :value="__('Fullname')" required/>
                    </div>
                    <div class="form-control-wrap">
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="Enter your name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <!-- Email Address -->
                <div class="form-group">
                    <div class="form-label-group">
                        <x-input-label for="email" :value="__('Email')" required/>
                    </div>
                    <div class="form-control-wrap">
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="Enter your email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <!-- Password -->
                <div class="form-group">
                    <div class="form-label-group">
                        <x-input-label for="password" :value="__('Password')" required/>
                    </div>
                    <div class="form-control-wrap">
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        placeholder="Enter your password"
                                        required autocomplete="new-password" required/>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <!-- Confirm Password -->
                <div class="form-group">
                    <div class="form-label-group">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" required/>
                    </div>
                    <div class="form-control-wrap">

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        placeholder="Confirm password"
                                        name="password_confirmation" required/>

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-control-wrap mt-3">
                    <div class="form-label-group">
                        <x-input-label for="password_confirmation" :value="__('Mobile')" required/>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend" >
                            <select class="custom-select" name="country_code" required style="height: 100%;">
                                @foreach(config('country_codes') as $countryNameCode => $countryCode)
                                    <option value="{{$countryCode}}" selected>{{$countryCode}}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-text-input name="mobile" type="tel" pattern="[0-9]{10}" placeholder="3001212123" required/>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="form-group mt-3">
                    <div class="custom-control custom-control-xs custom-checkbox">
                        <x-text-input name="terms" type="checkbox" id="checkbox" required/>
                        <x-input-label class="custom-control-label" for="checkbox">I agree to {{ config('app.name', 'Laravel') }} 
                            <a href="#">Privacy Policy</a> &amp; <a href="#"> Terms.</a>
                        </x-input-label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <x-primary-button>
                        {{ __('Sign Up') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
        
    <div class="form-note-s2 text-center pt-4"> 
        Already have an account? 
        <a href="{{ route('login') }}"><strong>Sign in instead</strong></a>
    </div>
    </form>
</x-guest-layout>
