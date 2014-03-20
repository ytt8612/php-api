<?php

class Core_Validator_ApiGeoPoint implements Core_Validator_ApiInterface{
    public function isValid($data){
        if(!is_array($data) || count($data) != 2){
            return false;
        }
        list($latitude, $longitude) = $data;
        if ($latitude < -90 || $latitude >= 90){
            return false;
        }
        if ($longitude < -180 || $longitude >= 180){
            return false;
        }
        return true;
    }
}
