<?php

use \Services\CompositeService;

class TestScript
{
    public function execute()
    {
        $start = microtime(true);
        $composite = new CompositeService();
        $result = $composite->get();
        echo 'Result:' . json_encode($result);
        echo 'Total time: '.  (microtime(true) - $start);
    }
}