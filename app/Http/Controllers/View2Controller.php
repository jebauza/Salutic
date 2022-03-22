<?php

namespace App\Http\Controllers;

use App\User;
use App\Center;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class View2Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('view2');
    }

    /**
     * Method usersAjax
     *
     * @param Request $request [explicite description]
     *
     * @return \Illuminate\Http\Response
     */
    public function usersAjax(Request $request)
    {
        $users = User::whereHas('center', function (Builder $query2) {
                            $query2->active()
                                    ->where('IDZONA', 1);
                        })
                        ->emailAndPhone($request->emailAndPhone)
                        ->center($request->center)
                        ->with('center')
                        ->orderBy('EMAIL')
                        ->get();

        return $this->sendResponse(null, $users);
    }

    /**
     * Method centersAjax
     *
     * @return \Illuminate\Http\Response
     */
    public function centersAjax()
    {
        $centers = Center::active()
                        ->where('IDZONA', 1)
                        ->orderBy('NOMBRE')
                        ->get();

        return $this->sendResponse(null, $centers);
    }

    /**
     * Method storeAjax
     *
     * @param Request $request [explicite description]
     *
     * @return \Illuminate\Http\Response
     */
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'last_name1' => ['required', 'string', 'max:100'],
            'last_name2' => ['required', 'string', 'max:100'],
            'phone1' => ['required', 'string', 'max:100'],
            'phone2' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:usuario,EMAIL'],
            'center' => ['required', 'integer', 'exists:centro,ID,ACTIVO,1,IDZONA,1'],
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
            return $this->sendResponse(__('Save successfully'), $user, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), null, 500);
        }


        dd('storeAjax', $request->all());
    }
}
