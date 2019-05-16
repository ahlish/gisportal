<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use Schema;
use Session;
use Redirect;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Models\AsalPengaduan;
use App\Models\JenisPengaduan;
use App\Models\TrialGISPengaduan;
use App\Helpers\StringHelper;
use App\Helpers\TokenHelper;

class MonitoringCaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = Route::currentRouteName();

        $periode = DB::connection("oracle_cater")->select("SELECT DISTINCT(periode) FROM t_histori WHERE periode IS NOT NULL ORDER BY periode ASC");

        return view('pages.monitoring_cater.index')
                ->with('route', $route)
                ->with('periode', $periode);
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

    public function MonitoringPengaduan()
    {
        $route = Route::currentRouteName();

        return view('pages.monitoring_pengaduan.index')
                ->with('route', $route);
    }
}
