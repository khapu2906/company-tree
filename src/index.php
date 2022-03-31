<?php

include('../Services/CompanyService.php');
include('../Services/TravelService.php');
include('../Services/CompositeService.php');
include('../Libs/Curl.php');
include('../Entities/Company.php');
include('../Entities/Travel.php');
include('./TestScript.php');

(new TestScript())->execute();