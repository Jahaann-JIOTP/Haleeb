<?php
error_reporting(E_ERROR | E_PARSE);
include('calculation/mongodb_conn.php');
date_default_timezone_set('Asia/Karachi');
$collection = $db->haleeb;

// Retrieve user input from the HTML form
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];
$selected_temperatures = $_POST["selected_temperatures"];
$selected_temp = $_POST["selected_pressure"]; // An array of selected field names
$start_date = date('Y-m-d 00:00:00', strtotime($start_date));
$end_date = date('Y-m-d 23:59:59', strtotime($end_date));

// Create a filter based on user input
$filter = [
    '$expr' => [
        '$and' => [
            [
                '$gte' => [
                    [
                        '$dateFromString' => [
                            'dateString' => '$payload.Time',
                            'format' => '%Y-%m-%dT%H:%M:%S.%L%z'
                        ]
                    ],
                    new MongoDB\BSON\UTCDateTime(new DateTime($start_date)),
                ],
            ],
            [
                '$lte' => [
                    [
                        '$dateFromString' => [
                            'dateString' => '$payload.Time',
                            'format' => '%Y-%m-%dT%H:%M:%S.%L%z'
                        ]
                    ],
                    new MongoDB\BSON\UTCDateTime(new DateTime($end_date)),
                ],
            ],
        ],
    ],
];

// Create an array to hold the selected tags
$selected_tags = [];

// If specific temperatures are selected, add them to the filter
if (is_array($selected_temperatures)) {
    foreach ($selected_temperatures as $temperature) {
        $selected_tags[] = 'payload.' . $temperature;
    }
}
if (is_array($selected_temp)) {
    foreach ($selected_temp as $pressure) {
        $selected_tags[] = 'payload.' . $pressure;
    }
}
// Query MongoDB to retrieve data based on the filter
$cursor = $collection->find($filter);

// Debug: Check if the cursor has results

// Display the data in an HTML table
echo '<table id="demo-table" style="display:none;">';
echo '<tr><th>Date</th>';
echo '<th>Time</th>';
foreach ($selected_tags as $tag) {
    // Extract the meter name from the tag
    $meterName = str_replace('payload.', '', $tag);
    if ($meterName == 'Steam_Value_PT1001_Scaled_for_Pressure_Percentage_control_valve') {
        $meterName = 'PCV-1001'; // Extract part before "_scaled"
    } else {
        $meterName = explode('_Scaled', $meterName)[0]; // Extract part before "_scaled"
    }
    
    // $meterName = explode('_Scaled', $meterName)[0]; // Extract part before "_scaled"
    echo '<th>' . $meterName . '</th>';
}
echo '</tr>';
foreach ($cursor as $document) {
    echo '<tr>';
    $timestamp = $document['payload']['Time'];
    $dateTime = new DateTime($timestamp);
    $formattedTime = $dateTime->format('Y-m-d');
    echo '<td>' . $formattedTime . '</td>';

    $timestamp1 = $document['payload']['Time'];
    $dateTime1 = new DateTime($timestamp1);
    $formattedTime1 = $dateTime1->format('H:i:s');
    echo '<td>' . $formattedTime1 . '</td>';
    // echo '<td>' . $document['payload']['Time'] . '</td>';
    foreach ($selected_tags as $tag) {
        $meterName = str_replace('payload.', '', $tag);
        $value = $document['payload'][$meterName];
        // Round the value to two decimal places
        $roundedValue = number_format($value, 2);
        echo '<td>' . $roundedValue . '</td>';
    }

    echo '</tr>';
}
echo '</table>';
?>
<!-- <button type="button" onload="">Generate PDF</button> -->
<script>
    generatereport();
</script>

