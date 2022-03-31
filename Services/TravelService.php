<?php

namespace Services;

use Libs\Curl;
use Entities\Travel;

class TravelService
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
        $url = $this->_curl->buildUrl('travel');
        $response = $this->_curl->get($url);
        $result = [];
        foreach ($response['data'] as $rep) {
            $ele = new Travel($rep);
            array_push($result, $ele);
        }
        uasort($result, function ($pre, $cur) {
            if ($pre->companyId == $cur->companyId) {
                return 0;
            }
            return ($pre->companyId > $cur->companyId) ? 1: -1;
        });
        return $result;
    }
}