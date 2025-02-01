<?php
require_once __DIR__ . "/vendor/autoload.php";
$mongo_url = 'mongodb://admin:cisco123@13.234.241.103:27017/iotdb?authSource=iotdb&readPreference=primary&appname=MongoDB%20Compass%20Community&ssl=false';
$client = new \MongoDB\Client($mongo_url);
$db_name = 'iotdb';
$db = $client->$db_name;
?>