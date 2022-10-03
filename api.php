<?php header('HTTP/1.0 200 OK'); 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include_once('engine/0.3/engine.php');
echo pGenerator::Generate()->JSON();?>