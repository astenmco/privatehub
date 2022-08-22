<?php

/**
 * The Utils class provides utility methods.
 * Most of these methods allows the interraction with the Docker Registry API V2.
 * Most are static methods to allow the call to the function from multiple contexts.
 * 
 */
final class Utils {

    /** 
     * If the array value is an JSON it returns it as an array else it returns it as it is.
     * 
     * @return array JSON subcontent  
     */
    public static function accessSubJSONAsArray($array){
        $sub = array();
        if (is_array($array)){
            foreach($array as $arrayK => $arrayV){
                if (is_array($arrayV)){
                    foreach($arrayV as $key => $value){
                        array_push($sub, json_decode($value, true));
                    } 
                } 
            } 
        } return $sub;
    } 

    /**
     * Gathers the data from a specified URL.
     * 
     * This functions requests an URL using CURL and HTTP. It does not return content but the HTTP HEADER from the request.
     * It is used to check 202 and 404 codes.
     * It must request URLS specified within the Registry API V2 from Docker.
     * 
     * @param $url The URL used to gater datas (ex: htpps://docker.io/v2/library/manifests/_catalog)
     * @return array Array containing all the json datas returned from the CURL request.  
     * @todo Check all results (202,404 etc)
     */
    public static function getHeadDataV2($url){
        
        $headers = [
            'Accept:application/vnd.docker.distribution.manifest.v2+json',
            'Accept:application/vnd.docker.distribution.manifest.list.v2+json',
            'X-Apple-Tz: 0',
            'X-Apple-Store-Front: 143444,12',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate',
            'Accept-Language: en-US,en;q=0.5',
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
            'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
            'X-MicrosoftAjax: Delta=true'
        ];
        $curl = curl_init();
        self::setMinimalCURLOptions($curl, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        self::setDebugCURLOptions($curl);
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;

    }

    /**
     * Gathers the JSON data from a specified URL.
     * 
     * This functions requests an URL using CURL and HTTP. The returned json is transformed into an array containing all the data returned.
     * It must request URLS specified within the Registry API V2 from Docker.
     * 
     * @param $url The URL used to gater datas (ex: htpps://docker.io/v2/library/manifests/_catalog)
     * @return array Array containing all the json datas returned from the CURL request.  
     * @todo Check all results (202,404 etc)
     */
    public static function getDataFromUrl($url){     
        $curl = curl_init();
        self::setMinimalCURLOptions($curl, $url);
        self::setDebugCURLOptions($curl);
        $resp = curl_exec($curl);
        curl_close($curl);
        $arr = json_decode($resp,true);
        return $arr;
    }

    /**
     * Set the minimal required options for a CURL simple request.
     * 
     * @param $curl must result from the curl_init of the url you are requesting. 
     */
    public static function setMinimalCURLOptions($curl,$url){
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
    } 

    /**
     * Set the minimal debug options for a CURL simple request.
     * 
     * @param $curl must result from the curl_init of the url you are requesting. 
     */
    public static function setDebugCURLOptions($curl){
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    } 

    /**
     * Gathers the JSON data from a specified URL.
     * 
     * This functions requests an URL using CURL and HTTP. It does  return the HTTP HEADER from the request.
     * It is used to check 202 and 404 codes for example.
     * It must request URLS specified within the Registry API V2 from Docker.
     * 
     * @param $url The URL used to gater datas (ex: htpps://docker.io/v2/library/manifests/_catalog)
     * @return array Array containing all the json datas returned from the CURL request.  
     * @TODO Check all results (202,404 etc)
     */
    public static function headDataFromUrl($url){

        $ch = curl_init();
        $headers = [
            'Accept:application/vnd.docker.distribution.manifest.v2+json',
            'Accept:application/vnd.docker.distribution.manifest.list.v2+json',
            'X-Apple-Tz: 0',
            'X-Apple-Store-Front: 143444,12',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate',
            'Accept-Language: en-US,en;q=0.5',
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
            'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
            'X-MicrosoftAjax: Delta=true'
        ];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            exit();
        }
        curl_close($ch);
        return $response;
    } 
    

}

?>