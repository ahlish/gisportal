<?php

namespace App\Http\Controllers\WebServices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Auth;
use Route;
use Schema;
use Session;
use Redirect;
use DB;
use Carbon\Carbon;

// MODELS
use App\Models\AsalPengaduan;
use App\Models\JenisPengaduan;
use App\Models\TrialGISPengaduan;

// HELPERS
use App\Helpers\StringHelper;
use App\Helpers\TokenHelper;

class MonitoringCaterServiceController extends BaseServiceController
{
    public function GetCater(Request $request)
    {
        $start_period = $request->start_period ? $request->start_period : '01'.date("Y")-1;
        $end_period = $request->end_period ? $request->end_period : '12'.date('Y')-1;

       	$data = DB::connection("oracle_cater")
                    ->select("SELECT nolang, periode, pos_long, pos_lat FROM t_histori
                                WHERE periode BETWEEN $start_period AND $end_period
                                  AND rownum <= 1000
                                ORDER BY periode ASC");

        return $this->createSuccessMessage($data);
    }   

}
