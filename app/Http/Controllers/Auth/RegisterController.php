<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Center;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $centers = Center::active()
                            ->orderBy('NOMBRE')
                            ->get();

        return view('auth.register', compact('centers'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'last_name1' => ['required', 'string', 'max:100'],
            'last_name2' => ['required', 'string', 'max:100'],
            'phone1' => ['required', 'string', 'max:100'],
            'phone2' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:usuario,EMAIL'],
            'center' => ['required', 'integer', 'exists:centro,ID,ACTIVO,1'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            DB::beginTransaction();

            $user = new User();
            $user->EMAIL = $request->email;
            $user->NOMBRE = $request->name;
            $user->APELLIDO1 = $request->last_name1;
            $user->APELLIDO2 = $request->last_name2;
            $user->TELEFONO1 = $request->phone1;
            $user->TELEFONO2 = $request->phone2;
            $user->PASSWORD = Hash::make($request->password);
            $user->ACTIVO = true;
            $user->INDEXPASSWORD = 1;
            $user->FECHAMODIFICACIONPASSWORD = Carbon::now();
            $user->NUMERO_INTENTOS = 0;
            $user->NUEVO = true;
            $user->IDCENTRO = $request->center;

            $user->save();
            DB::commit();
            event(new Registered($user));
            $this->guard()->login($user);

            return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('register')->withInput()->with('message-error', $e->getMessage());
        }
    }
}
