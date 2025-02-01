<?php
$url1 = "http://13.234.241.103:1880/haleeb_prod";
$json1 = file_get_contents($url1);
$msg1 = json_decode($json1, true);
$STEP10_COUNTER = 0;
if (isset($msg1['STEP10_COUNTER']))
    $STEP10_COUNTER = $msg1['STEP10_COUNTER'];
$MACHINE_ON_COUNTER = 0;
if (isset($msg1['MACHINE_ON_COUNTER']))
    $MACHINE_ON_COUNTER = $msg1['MACHINE_ON_COUNTER'];
$MACHINE_OFF_COUNTER = 0;
if (isset($msg1['MACHINE_OFF_COUNTER']))
    $MACHINE_OFF_COUNTER = $msg1['MACHINE_OFF_COUNTER'];
$STEP6_COUNTER = 0;
if (isset($msg1['STEP6_COUNTER']))
    $STEP6_COUNTER = $msg1['STEP6_COUNTER'];
$Production_Setup_COUNTER = 0;
if (isset($msg1['Production_Setup_COUNTER']))
    $Production_Setup_COUNTER = $msg1['Production_Setup_COUNTER'];

$url2 = "http://13.234.241.103:1880/prod_start";
$json2 = file_get_contents($url2);
$msg2 = json_decode($json2, true);
$Start_production_time = 0;
if (isset($msg2['Start_production_time']))
    $Start_production_time = $msg2['Start_production_time'];


$url3 = "http://13.234.241.103:1880/haleeb_prod_sec";
$json3 = file_get_contents($url3);
$msg3 = json_decode($json3, true);

$MACHINE_ON_COUNTER1 = 0;
if (isset($msg3['MACHINE_ON_COUNTER']))
    $MACHINE_ON_COUNTER1 = $msg3['MACHINE_ON_COUNTER'];

$STEP10_COUNTER1 = 0;
if (isset($msg3['STEP10_COUNTER']))
    $STEP10_COUNTER1 = $msg3['STEP10_COUNTER'];

$url0 = "http://13.234.241.103:1880/prod_duration";
$json0 = file_get_contents($url0);
$msg0 = json_decode($json0, true);

$STEP10_Duration = 0;
if (isset($msg0['STEP10_Duration']))
    $STEP10_Duration = $msg0['STEP10_Duration'];
