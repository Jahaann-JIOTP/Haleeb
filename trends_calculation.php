<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
include('calculation/mongodb_conn.php');

$collection = $db->haleeb;
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$location = $_GET["location"];
$selected_fields = explode(",", $location);

$start_date = date('Y-m-d', strtotime($start_date));
$start_date = $start_date;
$end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
$end_date = $end_date;

$result = array();

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

    $array = array();
    foreach ($docs as $document) {
        $document = json_decode(json_encode($document), true);
        $values = array();

        if (isset($document['payload'][$tag])) {
            if (is_array($document['payload'][$tag])) {
                foreach ($document['payload'][$tag] as $key => $value) {
                    $values[$key] = round($value, 1);
                }
            } else {
                $values = round($document['payload'][$tag], 1);
            }
        }

        if (!empty($values)) {
            $array[] = array('date' => $document['payload']['Time'], 'values' => $values);
        }
    }

    $result[$tag] = $array;
}

$data = json_encode($result);
echo $data;
?>