<?php

/**
 * Created by PhpStorm.
 * User: joseosuna
 * Date: 22/01/18
 * Time: 16:18
 */

namespace App\Helpers;

use SoapClient;
use SoapFault;
use SoapBox\Formatter\Formatter;

class SoapWrapper
{
    protected $wsdl;
    protected $options;
    protected $client;

    /**
     * Initialize the variables: URI of the WSDL file and an array of options (this parameter is optional, for example options of Login)
     *
     * @return void
     */
    public function __construct($url, $options = array())
    {
        $this->wsdl = $url;
        $this->options = $options;
    }

    /**
     * Try to connect to wsdl
     *
     * @return array $connection
     */
    public function connect()
    {
        $connection = array();
        try {
            $this->client = new SoapClient($this->wsdl, $this->options);
            $connection['success'] = true;
        } catch (\Exception $ex) {
            $connection['success'] = false;
            $connection['message'] = $ex->getMessage();
        }
        return $connection;
    }


    /**
     * Consume a specific method of webservice
     * if the connection is null, try to do it
     *
     * @param string $method
     * @param array $params
     * @return array $result
     */
    public function call($method, $params)
    {
        $result = array();

        if (is_null($this->client)) {
            $connection = $this->connect();
            if (!$connection['success']) {
                $result = $connection;
            }
        }else{
            $connection = array('success' => true);
        }

        if ($connection['success']) {
            try {
                $resultWs = $this->client->$method($params);
                $result['success'] = true;
                $result['result'] = $resultWs;
            } catch (SoapFault $ex) {
                $result['success'] = false;
                $result['message'] = $ex->getMessage();
            }
        }

        return $result;
    }

    public function XMLToArray($xmlOutput)
    {
        $result = array();
        try {
            $formatterXML = Formatter::make(preg_replace("/&(?!#?[a-z0-9]+;)/", "&amp;",(string)$xmlOutput), Formatter::XML);
            $result = $formatterXML->toArray();
        }catch (\Exception $ex) {

        }
        return $result;
    }

    public function __destruct()
    {
        $this->wsdl = '';
        $this->options = array();
        $this->client = null;
    }

}