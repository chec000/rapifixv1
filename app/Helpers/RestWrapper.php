<?php
/**
 * Created by PhpStorm.
 * User: joseosuna
 * Date: 24/01/18
 * Time: 16:46
 */

namespace App\Helpers;
use GuzzleHttp\Client as HttpClient;

class RestWrapper
{

    /**
     * @var HttpClient
     */
    protected $_httpClient;

    /**
     * @var url
     */
    protected $_url;

    public function __construct($url){
        $this->_url = $url;
        $this->_httpClient = new HttpClient;
    }

    public function call($method = 'POST', $params = [], $request = 'json', $options = [], $returnResponse = false){
        $result['success'] = true;
        $requestOptions = [$request => $params];
        if(is_array($options) && count($options) > 0){
            foreach ($options as $index => $value){
                $requestOptions[$index] = $value;
            }
        }
        try{
            $response = $this->_httpClient->request($method, $this->_url, $requestOptions);

            if($request == 'json'){
                $result['responseWS'] = !$returnResponse ? json_decode($response->getBody(), true) : $response;
            }else{
                $result['responseWS'] = !$returnResponse ? $response->getBody()->close() : $response;
            }

            if($response->getStatusCode() == 200){
                $result['success'] = true;
            }else{
                $result['success'] = false;
                $result['message'] = "E: ".$response->getStatusCode()." ".$response->getReasonPhrase();
            }

        }catch(\Exception $ex){
            $result['success'] = false;
            $result['message'] = $ex->getMessage();
        }

        return $result;
    }
}