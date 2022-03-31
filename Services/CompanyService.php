<?php

namespace Services;

use Libs\Curl;
use Entities\Company;

class CompanyService
{

    /**
     * @var Curl
     */
    private $_curl;

    public function __construct(Curl $curl)
    {
        $this->_curl = $curl;
    }

    public function get()
    {
        $url = $this->_curl->buildUrl('company');
        $response = $this->_curl->get($url);
        $result = [];
        foreach ($response['data'] as $rep) {
            $ele = new Company($rep);
            array_push($result, $ele);
        }
        return $result;
    }
}