<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Route;
use Schema;
use Session;
use Redirect;
use Validator;
use DB;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Models\AsalPengaduan;
use App\Models\JenisPengaduan;
use App\Models\TrialGISPengaduan;
use App\Helpers\StringHelper;
use App\Helpers\TokenHelper;
use App\User;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function login()
    {
        return view('auth.login');
    }

    public function checkLogin(Request $request)
    {
        if (Auth::attempt(array('email' => $request->username, 'password' => $request->password),true))
        {

            return Redirect::to('/point');
        } else {
            return Redirect::to('/login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
}
