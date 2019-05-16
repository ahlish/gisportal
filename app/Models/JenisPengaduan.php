<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengaduan extends Model
{
    protected $table = 'jenis_pengaduan';

    public static function GetData($key_sort, $sort)
    {
    	$data = JenisPengaduan::orderBy($key_sort, $sort)
    						->get();

    	return $data;
    }
}
