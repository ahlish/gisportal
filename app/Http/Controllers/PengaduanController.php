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

class PengaduanController extends Controller
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
        $route = Route::currentRouteName();

        $asal_pengaduan = AsalPengaduan::GetData('keterangan', 'ASC');
        $jenis_pengaduan = JenisPengaduan::GetData('keterangan', 'ASC');

        return view('pages.pengaduan.create')
                ->with('route', $route)
                ->with('asal_pengaduan', $asal_pengaduan)
                ->with('jenis_pengaduan', $jenis_pengaduan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $prefix = "B".date('Y');
            $no_pengaduan = StringHelper::guid("B", 5, true);
            // $new_pengaduan = new TrialGISPengaduan;
            // $new_pengaduan->no_pengaduan = $no_pengaduan;
            // $new_pengaduan->no_plg = 1;
            // $new_pengaduan->jns_pengaduan = $request->jenis_pengaduan;
            // $new_pengaduan->jns_pengadu = 0;
            // $new_pengaduan->st_pengadu = 0;
            // $new_pengaduan->tgl_pengaduan = date("Y-m-d");
            // $new_pengaduan->zona = $request->zona;
            // $new_pengaduan->asal_pengaduan = $request->asal_pengaduan;
            // $new_pengaduan->uraian = $request->uraian;
            // $new_pengaduan->nama_pengadu  = $request->nama_pelapor;
            // $new_pengaduan->alamat_pengadu = $request->alamat_pengaduan;
            // $new_pengaduan->telepon = $request->telepon_pelapor;
            // $new_pengaduan->save();
            //
            $new_pengaduan = DB::statement("insert into trialgis_pengaduan (no_pengaduan, no_plg, jns_pengaduan, jns_pengadu, st_pengaduan, tgl_pengaduan, zona, asal_pengaduan, uraian, nama_pengadu, alamat_pengadu, telepon, created_at,updated_at) values ('".$no_pengaduan."',1,'".$request->jenis_pengaduan."',0, 0,'".Carbon::now()."','".$request->zona."','".$request->asal_pengaduan."','".$request->uraian."','".$request->nama_pelapor."','".$request->alamat_pengaduan."','".$request->telepon_pelapor."', '".Carbon::now()."', '".Carbon::now()."') ");

            DB::commit();

            $url = "https://gis.pdam-sby.go.id/server/rest/services/trial_pengaduan/FeatureServer/0";

            $token = json_decode(TokenHelper::GetToken2($url));

            // return $token->token;
            $client = new \GuzzleHttp\Client();
            // $url = "https://services9.arcgis.com/gpK1YezplsYw1fNR/arcgis/rest/services/test_layer/FeatureServer/0/applyEdits";
            $url_apply_edits = "https://gis.pdam-sby.go.id/server/rest/services/trial_pengaduan/FeatureServer/0/applyEdits";

            $new_graphic = array();
            $geometry['type'] = 'point';
            $geometry['x'] = $request->longitude;
            $geometry['y'] = $request->latitude;

            $data_wkid['wkid'] = 4326;
            $geometry['spatialReference'] = $data_wkid;

            $attributes['nopengaduan'] = $no_pengaduan;
            $graph['geometry'] = $geometry;
            $graph['attributes'] = $attributes;
            $new_graphic[0] = $graph;

            $response = $client->request("POST", $url_apply_edits, [
                'form_params' => [
                    'f' => "json",
                    'token' => $token->token,
                    'adds' => json_encode($new_graphic)
                ]
            ]);

            Session::flash('status', 'Your report has been delivered with report number : '.$no_pengaduan);
            // $route = Route::currentRouteName();

            // $asal_pengaduan = AsalPengaduan::GetData('keterangan', 'ASC');
            // $jenis_pengaduan = JenisPengaduan::GetData('keterangan', 'ASC');

            // return view('pages.pengaduan.create')
            //         ->with('route', $route)
            //         ->with('asal_pengaduan', $asal_pengaduan)
            //         ->with('jenis_pengaduan', $jenis_pengaduan)
            //         ->with('pengaduan', $new_pengaduan);

        } catch (\Exception $e) {
            Session::flash('warning', 'Error '.$e->getMessage());
            return back()->withInput();
            // something went wrong
        }
        return Redirect::to('pengaduan/create');
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

    public function test()
    {
        return "a";
    }
}
