<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class PortalController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function KebocoranPipa()
    {
    	$route = Route::currentRouteName();
        return view('pages.kebocoran_pipa.index')
        		->with('route', $route);
    }

    public function PasangBaru()
    {
    	$route = Route::currentRouteName();
        return view('pages.pasang_baru.index')
        		->with('route', $route);
    }

    public function Point()
    {
        $route = Route::currentRouteName();

        return view('pages.point.index')
                ->with('route', $route);
    }

    public function Line()
    {
        $route = Route::currentRouteName();

        return view('pages.line.index')
                ->with('route', $route);
    }

    public function Polygon()
    {
        $route = Route::currentRouteName();

        return view('pages.polygon.index')
                ->with('route', $route);
    }
}