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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function usersAjax(Request $request)
    {
        $users = User::centers($this->centerIds)
                        ->name($request->name)
                        ->center($request->center)
                        ->with('center')
                        ->get();

        return $this->sendResponse(null, $users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function centersAjax()
    {
        $centers = Center::whereIn('ID', $this->centerIds)->get();

        return $this->sendResponse(null, $centers);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyUserAjax(Request $request, $userId)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
