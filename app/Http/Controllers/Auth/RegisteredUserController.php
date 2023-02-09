<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\LoginLogTrait;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    use LoginLogTrait;
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'country_code'   => ['required', 'regex:/[0-9]{2}/'],
            'mobile'         => ['required', 'regex:/[0-9]{10}/'],
            'terms'          => ['required'],
        ], [
            'terms.required' => 'You must accpet the terms and conditions'
        ]);

        try{
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'country_code' => $request->country_code,
                'mobile' => $request->mobile,
                'ref_by' => request()->ref ? User::select('id')->whereUuid(request()->ref)->firstOrFail()->id : null,
            ]);
            DB::commit();

            $this->createLoginLog($user);

            event(new Registered($user));
    
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME);
        } catch(ModelNotFoundException $e){
            DB::rollBack();
            return response()->json([], JsonResponse::HTTP_OK);
        }
        
    }
}
