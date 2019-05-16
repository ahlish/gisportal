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

class CustomerServiceController extends BaseServiceController
{
    public function PelangganDetail($id)
    {
        if ($id) {
            $data = DB::table('dil')
                        ->whereRaw("no_plg = '".$id."'")
                        ->first();

            return response()->json($data);
        }
    }

    public function AjaxPelanggan(Request $request)
    {
        if ($request->has('q')) {
            $cari = $request->q;

            $data = DB::table('dil')
                        ->whereRaw("lower(nama) LIKE  '%".$cari."%'")
                        ->orderBy('nama', 'ASC')
                        ->limit(20)
                        ->get();

            return response()->json($data);
        }
    }

}
