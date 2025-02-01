<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
include('mongodb_conn.php');

$collection = $db->haleeb_prod;

// Fetch today's efficiency from the external API
$url4 = "http://13.234.241.103:1880/haleeb_prod_sec";
$json4 = file_get_contents($url4);
$msg4 = json_decode($json4, true);

$STEP10_COUNTER1 = 0;
if (isset($msg4['STEP10_COUNTER'])) {
    $STEP10_COUNTER1 = $msg4['STEP10_COUNTER'];
}
$today_efficency = round(($STEP10_COUNTER1 / 86400) * 100, 2);

$start_date = null;
$end_date = null;
$date_format = "Y-m-d";

if ($_GET["select_date"] == "today-yesterday") {
    $start_date = date($date_format, strtotime('yesterday'));
    $end_date = date($date_format);
} elseif ($_GET["select_date"] == "this-week-last-week") {
    $today = new DateTime();
    $current_week_start = $today->modify('monday this week')->format($date_format);
    $current_week_end = $today->modify('sunday this week')->format($date_format);

    // Calculate previous week's start and end dates
    $previous_week_start = (clone $today)->modify('-1 week')->modify('monday this week')->format($date_format);
    $previous_week_end = (clone $today)->modify('-1 week')->modify('sunday this week')->format($date_format);

    $start_date = $current_week_start;
    $end_date = $current_week_end;
} elseif ($_GET["select_date"] == "this-month-last-month") {
    $start_date = date($date_format, strtotime('first day of this month'));
    $end_date = date($date_format, strtotime('last day of this month'));
}

// Adjusting end date for the query to include the entire end date
$end_date = date($date_format, strtotime($end_date . ' +1 day'));

// Initialize an array to hold the results
$result = [];
$daily_values = [];

// Generate all dates in the range and initialize them with 0 efficiency
$period = new DatePeriod(
    new DateTime($start_date),
    new DateInterval('P1D'),
    new DateTime($end_date)
);

foreach ($period as $date) {
    $daily_values[$date->format($date_format)] = 0;
}

$location = "Efficiency";
$selected_fields = explode(",", $location);
if ($_GET["select_date"] == "today-yesterday") {
    foreach ($selected_fields as $tag) {
        $where = array(
            'payload.Time' => array('$gte' => $start_date, '$lt' => $end_date)
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
            $date = date($date_format, strtotime($document['payload']['Time']));

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
    }
}
if ($_GET["select_date"] == "this-week-last-week") {
    foreach ($selected_fields as $tag) {
        // Fetch data for current week
        $where_current = array(
            'payload.Time' => array('$gte' => $current_week_start, '$lte' => $current_week_end)
        );

        // Fetch data for previous week
        $where_previous = array(
            'payload.Time' => array('$gte' => $previous_week_start, '$lte' => $previous_week_end)
        );

        $select_fields = array(
            'payload.Time' => 1,
            'payload.' . $tag => 1
        );

        $options = array(
            'projection' => $select_fields
        );

        // Fetch current week's data
        $cursor_current = $collection->find($where_current, $options);
        $docs_current = $cursor_current->toArray();

        // Fetch previous week's data
        $cursor_previous = $collection->find($where_previous, $options);
        $docs_previous = $cursor_previous->toArray();

        // Process current week's data
        foreach ($docs_current as $document) {
            $document = json_decode(json_encode($document), true);
            $date = date($date_format, strtotime($document['payload']['Time']));

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

        // Process previous week's data
        foreach ($docs_previous as $document) {
            $document = json_decode(json_encode($document), true);
            $date = date($date_format, strtotime($document['payload']['Time']));

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
    }
}
// Generate the chart data based on the selected date range
if ($_GET["select_date"] == "today-yesterday") {
    $yesterday = date($date_format, strtotime('yesterday'));

    $result[] = array(
        "category" => "Today Over Yesterday",
        "currentEfficiency" => $today_efficency, // Use today's efficiency fetched from external API
        "previousEfficiency" => isset($daily_values[$yesterday]) ? $daily_values[$yesterday] : 0
    );
} elseif ($_GET["select_date"] == "this-week-last-week") {
    $days_of_week = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

    // Loop through days of the week and fetch efficiencies
    for ($i = 0; $i < 7; $i++) {
        $current_day = date($date_format, strtotime("$current_week_start +$i days"));
        $previous_day = date($date_format, strtotime("$previous_week_start +$i days"));

        // Ensure today's efficiency is calculated and displayed if it's within the current week
        $current_efficiency = isset($daily_values[$current_day]) ? $daily_values[$current_day] : 0;
        if ($current_day == date($date_format)) {
            $current_efficiency = $today_efficency;
        }

        $result[] = array(
            "category" => $days_of_week[$i],
            "currentEfficiency" => $current_efficiency,
            "previousEfficiency" => isset($daily_values[$previous_day]) ? $daily_values[$previous_day] : 0
        );
    }
} elseif ($_GET["select_date"] == "this-month-last-month") {
    $weeks_of_month = ["Week 1", "Week 2", "Week 3", "Week 4", "Week 5"];
    $start_of_last_month = date($date_format, strtotime('first day of last month'));
    $end_of_last_month = date($date_format, strtotime('last day of last month'));

    for ($i = 0; $i < 5; $i++) {
        $current_week_start = date($date_format, strtotime("$start_date +$i weeks"));
        $current_week_end = date($date_format, strtotime("$current_week_start +6 days"));
        $previous_week_start = date($date_format, strtotime("$start_of_last_month +$i weeks"));
        $previous_week_end = date($date_format, strtotime("$previous_week_start +6 days"));

        $current_efficiency = 0;
        $previous_efficiency = 0;

        foreach ($daily_values as $date => $value) {
            if ($date >= $current_week_start && $date <= $current_week_end) {
                $current_efficiency += $value;
            }
            if ($date >= $previous_week_start && $date <= $previous_week_end) {
                $previous_efficiency += $value;
            }
        }

        $result[] = array(
            "category" => $weeks_of_month[$i],
            "currentEfficiency" => $current_efficiency,
            "previousEfficiency" => $previous_efficiency
        );
    }
}

$data = json_encode($result);
echo $data;
