<?php

class Enom {
    /*
     * The username of the enom accounts used for enom
     */

    private $username = ENOM_USERNAME;

    /*
     * The password of the enom accounts used for enom
     */
    private $password = ENOM_PASSWORD;

    /*
     * The public url used for live or testing mode 
     */
    private $publicUrl = 'http://enom.com/interface.asp?';

    /*
     * The public url used for live or testing mode 
     */
    private $testingUrl = 'https://resellertest.enom.com/interface.asp?';

    /*
     * The mode - live, testing
     */
    private $mode = ENOM_MODE;

    public function __construct() {
        if ($this->mode == 'testing') {
            $this->baseUrl = $this->testingUrl;
        } else if ($this->mode == 'live') {
            $this->baseUrl = $this->publicUrl;
        } else {
            throw new Exception("Invalid base URL found. Mode must be 'testing' or 'live'.");
        }
    }

    public function call($method, $params = array()) {
        $this->method = $method;
        $this->params = $params;
        return $this->makeRequest();
    }

    private function makeRequest() {
        $this->queryParams = http_build_query($this->params);
        if ($this->queryParams) {
            $this->queryParams = '&' . $this->queryParams;
        }
        $this->FullURL = $this->baseUrl . 'Command=' . $this->method . '&UID=' . $this->username . '&PW=' . $this->password . $this->queryParams . '&ResponseType=xml';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->FullURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($output);
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }

}
