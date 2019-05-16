<?php
namespace App\Helpers;

use App\User;

class TokenHelper {

	public static function GetToken(){
        $client = new \GuzzleHttp\Client();

        //
        // ZENZIVA
        $url = getenv('ARCGIS_URL_GET_TOKEN');
        $response = $client->request("POST", $url, [
            'form_params' => [
                'client_id' => getenv('ARCGIS_CLIENT_ID'),
                'client_secret' => getenv('ARCGIS_CLIENT_SECRET'),
                'grant_type' => 'client_credentials',
            ]
        ]);

        return $response->getBody();
	}


    public static function GetToken2($url) 
    {
        $client = new \GuzzleHttp\Client();

        //
        // ZENZIVA
        $url = getenv('ARCGIS_URL_TOKEN_2');
        $response = $client->request("POST", $url, [
            'form_params' => [
                'username' => getenv('ARCGIS_USERNAME'),
                'password' => getenv('ARCGIS_PASSWORD'),
                'referer' => $url,
                'expiration' => 60,
                'f' => 'json'
            ]
        ]);

        return $response->getBody();
    }

}
