<div class="modal fade show" role="dialog" id="profile-edit" aria-modal="true" style="padding-right: 17px; display: block;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Update Profile</h5>
                <ul class="nk-nav nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#personal">Personal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#address">Address</a>
                    </li>
                </ul><!-- .nav-tabs -->
                <div class="tab-content">
                    <div class="tab-pane active" id="personal">
                        <form data-form="ajax-form" method="POST" action="{{route('profile.update')}}" data-close="profile-edit" data-redirect-url="{{route('profile.show')}}" class="tab-content">
                            @csrf
                            @method('PATCH')
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <x-input-label for="name" :value="__('Fullname')" required/>
                                        </div>
                                        <div class="form-control-wrap">
                                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="Enter your name" :value="$user->name" required autofocus />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <x-input-label for="name" :value="__('Email')" required/>
                                        </div>
                                        <div class="form-control-wrap">
                                            <x-text-input id="name" class="block mt-1 w-full" type="email" name="email" placeholder="Enter your email" :value="$user->email" disabled required/>
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-control-wrap">
                                        <div class="form-label-group">
                                            <x-input-label for="password_confirmation" :value="__('Mobile')" required/>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend" >
                                                <select class="custom-select" name="country_code" required style="height: 100%;">
                                                    @foreach(config('country_codes') as $countryNameCode => $countryCode)
                                                        <option value="{{$countryCode}}" @if($user->country_code == $countryCode)selected @endif selected>{{$countryCode}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <x-text-input name="mobile" type="tel" pattern="[0-9]{10}" value="{{$user->mobile}}" placeholder="3001212123" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-lg btn-primary">Update Profile</button>
                                        </li>
                                        <li>
                                            <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div><!-- .tab-pane -->
                    <div class="tab-pane" id="address">
                        <form data-form="ajax-form" method="POST" action="{{route('profile.update')}}" data-redirect-url="{{route('profile.show')}}" data-close="profile-edit" class="tab-content">
                            @csrf
                            @method('PATCH')
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l1">Address</label>
                                        <input type="text" class="form-control form-control-lg" id="address-l1" name="address[address]" value="{{$user->address->address}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-st">State</label>
                                        <input type="text" class="form-control form-control-lg" id="address-st" name="address[state]" value="{{$user->address->state}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-county">Country</label>
                                        <select class="form-select select2-hidden-accessible" id="address-county" name="address[country]" data-ui="lg" data-select2-id="address-county" tabindex="-1" aria-hidden="true">
                                            @foreach (['Pakistan', 'Afghanistan', 'India'] as $country)
                                                <option @if(strToLower($user->address->country) == $country) selected @endif>{{$country}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-lg btn-primary">Update Address</button>
                                        </li>
                                        <li>
                                            <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>