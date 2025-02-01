<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
include('mongodb_conn.php');

$collection = $db->haleeb_prod;
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$location = "Efficiency";
$selected_fields = explode(",", $location);
$url4 = "http://13.234.241.103:1880/haleeb_prod_sec";
$json4 = file_get_contents($url4);
$msg4 = json_decode($json4, true);

$STEP10_COUNTER1 = 0;
if (isset($msg4['STEP10_COUNTER'])) {
    $STEP10_COUNTER1 = $msg4['STEP10_COUNTER'];
}
$today_efficency = round(($STEP10_COUNTER1 / 86400) * 100, 2);
$today_date = date('Y-m-d'); // Today's date
$start_date = date('Y-m-d', strtotime($start_date));
$end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));

// Initialize an array to hold the results
$result = [];

// Generate all dates in the range and initialize them with 0 efficiency
$period = new DatePeriod(
    new DateTime($start_date),
    new DateInterval('P1D'),
    new DateTime($end_date)
);

// Calculate daily efficiency values
foreach ($selected_fields as $tag) {
    $daily_values = []; // Initialize daily values for each tag

    foreach ($period as $date) {
        $daily_values[$date->format('Y-m-d')] = 0; // Initialize daily efficiency to 0
    }

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

    foreach ($docs as $document) {
        $document = json_decode(json_encode($document), true);
        $date = date('Y-m-d', strtotime($document['payload']['Time']));

        if (isset($document['payload'][$tag])) {
            if (is_array($document['payload'][$tag])) {
                foreach ($document['payload'][$tag] as $value) {
                    $daily_values[$date] += round($value, 1);
                }
            } else {
                $daily_values[$date] += round($document['payload'][$tag], 1);
            }
        }
    }

    // Merge daily values into the final result array
    foreach ($daily_values as $date => $value) {
        $result[] = array(
            "date" => $date,
            "efficiency" => round($value, 2)
        );
    }
}

// Check if today's date is within the selected range
if ($today_date >= $start_date && $today_date < $end_date) {
    // Include today's efficiency in the result for today's date only
    $result[] = array(
        "date" => $today_date,
        "efficiency" => $today_efficency
    );
}

// Encode the result as JSON and output
$data = json_encode($result);
echo $data;
?>
