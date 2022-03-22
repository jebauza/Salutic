<?php

namespace App\Http\Controllers;

use App\User;
use App\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class View1Controller extends Controller
{
    protected $centerIds;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->centerIds = [Center::CENTRO_NORTE_ID, Center::CENTRO_SUR_ID];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('view1');
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
        $users = User::centers($this->centerIds)
                        ->name($request->name)
                        ->center($request->center)
                        ->with('center')
                        ->orderBy('NOMBRE')
                        ->orderBy('APELLIDO1')
                        ->orderBy('APELLIDO2')
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
        $centers = Center::whereIn('ID', $this->centerIds)
                            ->orderBy('NOMBRE')
                            ->get();

        return $this->sendResponse(null, $centers);
    }

    /**
     * Method destroyUserAjax
     *
     * @param Request $request [explicite description]
     * @param $userId $userId [explicite description]
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyUserAjax($userId)
    {
        $user = User::centers($this->centerIds)
                    ->center(Center::CENTRO_NORTE_ID)
                    ->findOrfail($userId);

        try {
            DB::beginTransaction();

            DB::table('usuario')->where('ID', $user->ID)->delete();

            DB::commit();
            return $this->sendResponse(__('The :resource was deleted!', ['resource' => strtolower(__('User'))]));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), null, 500);
        }
    }
}
