<?php

namespace App\Http\Controllers\WebServices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Mail;
use Validator;
use File;
use Config;
use Image;
use DateTime;

class BaseServiceController extends Controller
{
	public function createErrorMessage($message, $errorCode){
		$result = [ "payload"=>'',
				    "error_msg"=>$message,
					"code"=>$errorCode
					];
		return Response::json($result, $errorCode);
	}

	public function createSuccessMessage($payload){
		$result = [ "payload"=>$payload,
				    "error_msg"=>'',
					"code"=>200
					];
		return Response::json($result);
	}
}