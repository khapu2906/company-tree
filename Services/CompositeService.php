<?php

namespace Services;

use \Services\CompanyService;
use \Services\TravelService;
use \Libs\Curl;

class CompositeService
{
    /**
     * @var CompanyService
     */
    private CompanyService $_companyService;

    /**
     * @var TravelService
     */
    private TravelService $_travelService;

    public function __construct()
    {
        $curl = Curl::getInstance();
        $this->_companyService = new CompanyService($curl);
        $this->_travelService = new TravelService($curl);
    }

    /**
     * @param array $companies
     * @param array $travels
     * 
     * @return array 
     */
    private function _merge(array $companies, array $travels)
    {
        for($i = 0; $i < count($companies); $i ++) {
            foreach ($travels as $travel) {
                if ($companies[$i]->id == $travel->companyId) {
                    $companies[$i]->cost += $travel->price;
                }
            }
        }
        return $companies;
    }
    
    /**
     * @param array $companies
     * 
     * @return array 
     */
    private function _nested(array $companies) 
    {
        $count = count($companies);
        for($i = 0; $i < $count - 1; $i ++) {
            for ($j = $i + 1; $j < $count; $j ++) {
                if ($companies[$i]->parentId == $companies[$j]->id) {
                    $data = [
                        'id' => $companies[$i]->id,
                        'name' => $companies[$i]->name,
                        'cost' => $companies[$i]->cost,
                        'children' => $companies[$i]->children,
                    ];
                    $companies[$j]->cost += $data['cost'];
                    array_push($companies[$j]->children, $data);
                    unset($companies[$i]);
                    break;
                }
            }
        }
        return $companies;
    }

    /**
     * @return array
     */
    public function get()
    {
        $companies = $this->_companyService->get();
        $travels = $this->_travelService->get();
        $mergeData = $this->_merge($companies, $travels);
        uasort($mergeData, function ($pre, $cur) {
            [, $preNumber] = explode('-', $pre->parentId);
            [, $curNumber] = explode('-', $cur->parentId);
            if ($preNumber == $curNumber) {
                return 0;
            }
            return ($preNumber < $curNumber) ? 1: -1;
        });
        $data = [...$mergeData];
        $newData = $this->_nested($data);
        return $newData;
    }

}