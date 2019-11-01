<?php
/**
 * OpenSSL Crypt
 * 
 * @author Zapic
 * @version 0.0.1
 */
class OpenSSLCrypt {
    private $localIV;
    private $cryptKey;
    private $cryptMethod;
    private $raw;

    function __construct($encryptKey,$localIV = "",$raw = false,$crypt = "AES-256-CFB"){
        $this -> setlocalIV($localIV);
        $this -> setCryptKey($encryptKey);
        $this -> setRaw($raw);
        $this -> setCryptMethod($crypt);
    }

    function setlocalIV($localIV){
        $this -> localIV = $localIV;
        return true;
    }
    function setCryptKey($key){
        $this -> cryptKey = $key;
        return true;
    }
    function setCryptMethod($method){
        $methods = openssl_get_cipher_methods(true);
        $method = strtolower($method);
        if(!in_array($method,$methods)){
            return false;
        }
        $this -> cryptMethod = $method;
    }
    function setRaw($bool){
        if($bool){
            $this -> raw = OPENSSL_RAW_DATA;
        } else {
            $this -> raw = 0;
        }
    }

    function encrypt($data,$cryptKey = NULL,$localIV = NULL,$raw = NULL,$crypt = NULL){
        $cryptKey = $cryptKey === NULL ? $this -> cryptKey : $cryptKey;
        $localIV = $localIV === NULL ? $this -> localIV : $localIV;
        $raw = $raw === NULL ? $this -> raw : $raw;
        $raw = $raw === NULL ? $this -> raw : $raw ? OPENSSL_RAW_DATA : 0;
        $crypt = $crypt === NULL ? $this -> cryptMethod : $crypt;
        if($localIV == ""){
            return openssl_encrypt($data, $crypt, $cryptKey, $raw);
        }
        return openssl_encrypt($data, $crypt, $cryptKey, $raw, $localIV);
    }
    function decrypt($data,$cryptKey = NULL,$localIV = NULL,$raw = NULL,$crypt = NULL){
        $cryptKey = $cryptKey === NULL ? $this -> cryptKey : $cryptKey;
        $localIV = $localIV === NULL ? $this -> localIV : $localIV;
        $raw = $raw === NULL ? $this -> raw : $raw ? OPENSSL_RAW_DATA : 0;
        $crypt = $crypt === NULL ? $this -> cryptMethod : $crypt;
        if($localIV == ""){
            return openssl_decrypt($data, $crypt, $cryptKey, $raw);
        }
        return openssl_decrypt($data, $crypt, $cryptKey, $raw, $localIV);
    }
}