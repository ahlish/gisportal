<?php
namespace App\Helpers;

use App\User;

class StringHelper {

	public static function guid($prefix = null, $length = 8, $numeric = null){
        $token="";
        if ($numeric) {
            $codeAlphabet = "0123456789";
        } else {
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
        }

        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[User::crypto_rand_secure(0, $max-1)];
        }

        $code = $prefix.$token;

        return $code;
	}

    public static function AlphaNumericOnly($text)
    {
        $arr_text = str_split($text);
        $arr_text_new = array();

        foreach ($arr_text as $key => $value) {
            if(ctype_alnum($value)){
                array_push($arr_text_new, $value);
            }
            else{
                array_push($arr_text_new, " ");
            }
        }

        $result = implode("", $arr_text_new);
        return $result;
    }
}
