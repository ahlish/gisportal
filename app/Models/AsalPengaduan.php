<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsalPengaduan extends Model
{
    protected $table = 'asal_pengaduan';

    public static function GetData($key_sort, $sort)
    {
    	$data = AsalPengaduan::orderBy($key_sort, $sort)
    						->get();

    	return $data;
    }
}
