<?php
namespace Mini\Core;

class ModelCurl
{
    protected $curl = null;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    public function POST(string $destination, $fields, $header)
    {
        curl_setopt_array($this->curl, array(            
            // CURLOPT_PORT => 4664,
            CURLOPT_POST => true,            
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => CURL_HOST.$destination,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $fields
        ));
        return json_decode(curl_exec($this->curl));
    }

    public function GET(string $destination)
    {

        curl_setopt_array($this->curl,array(
            // CURLOPT_PORT => 80,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => CURL_HOST.$destination,          
            // CURLOPT_HTTPHEADER => array("Cache-Control: no-cache", "Content-Type: application/json")
        ));
        return json_decode(curl_exec($this->curl));
    }    
}