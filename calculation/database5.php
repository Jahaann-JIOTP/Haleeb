<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
include('mongodb_conn.php');

$collection = $db->haleeb_prod;
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$location = "Production_Setup_COUNTER,MACHINE_OFF_COUNTER,STEP10_COUNTER,STEP6_COUNTER";
$selected_fields = explode(",", $location);

$start_date = date('Y-m-d', strtotime($start_date));
$start_date = $start_date;
$end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
$end_date = $end_date;

$result = array(
    array("steps" => "Production Setup Time", "times" => 0),
    array("steps" => "Production Time", "times" => 0),
    array("steps" => "Idle State", "times" => 0),
    array("steps" => "Plant OFF", "times" => 0)
);

foreach ($selected_fields as $tag) {
    $where = array(
        'payload.Time' => array('$gt' => $start_date, '$lte' => $end_date)
    );

    $select_fields = array(
        'payload.Time' => 1,
        'payload.' . $tag => 1
    );

    $options = array(
        'projection' => $select_fields
    );

    $cursor = $collection->find($where, $options);
    $docs = $cursor->toArray();

    $values = 0;
    foreach ($docs as $document) {
        $document = json_decode(json_encode($document), true);

        if (isset($document['payload'][$tag])) {
            if (is_array($document['payload'][$tag])) {
                foreach ($document['payload'][$tag] as $value) {
                    $values += round($value, 1);
                }
            } else {
                $values += round($document['payload'][$tag], 1);
            }
        }
    }

    switch ($tag) {
        case 'Production_Setup_COUNTER':
          $result[0]['stimes'] = $values;
            $result[0]['times'] = secondsToMinutesAndSeconds($values);
            break;
        case 'STEP10_COUNTER':
          $result[1]['stimes'] = $values;
            $result[1]['times'] = secondsToMinutesAndSeconds($values);
            break;
        case 'STEP6_COUNTER':
          $result[2]['stimes'] = $values;
            $result[2]['times'] = secondsToMinutesAndSeconds($values);
            break;
        case 'MACHINE_OFF_COUNTER':
          $result[3]['stimes'] = $values;
            $result[3]['times'] = secondsToMinutesAndSeconds($values);
            break;
    }
}

$data = json_encode($result);
echo $data;
// Function to convert seconds to minutes and seconds
function secondsToMinutesAndSeconds($seconds)
{
    // Calculate the hours 
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $remainingSeconds = $seconds % 60;
    return $hours . " h  " . $minutes . " m  " . $remainingSeconds . " s";
}
?>
