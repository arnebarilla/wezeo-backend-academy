<?php

/**
 * Records a new arrival to the JSON file.
 * 
 * @param string $filename path to the JSON file.
 * @return array updated list of arrivals.
 */
function recordArrival(string $filename): ?array {
    $timestamp = date("Y-m-d H:i:s");
    $hour = (int) date("H");
    $minute = (int) date("i");

    if ($hour >= 20 && !($hour == 20 && $minute == 0)) return null;
    $onTime = true;
    if (($hour >= 8 && $hour <= 19 && !($hour == 8 && $minute == 0))
        || ($hour == 20 && $minute == 0)) {
        $onTime = false;
    }

    $arrivals = json_decode(file_get_contents($filename), true) ?? [];

    $record = ["time" => $timestamp];
    if (!$onTime) $record["note"] = "meškanie";
    $arrivals[] = $record;

    file_put_contents($filename, json_encode($arrivals));

    return $arrivals;
}

/**
 * Prints all arrivals to the browser.
 * 
 * @param array $arrivals list of arrival records.
 * @return void
 */
function printOut(?array $arrivals): void {
    echo "Timestamp:" . str_repeat("&nbsp;", 18) . "Note: <br>";
    foreach ($arrivals as $record) {
        echo $record['time'];
        if (isset($record['note'])) {
            echo str_repeat("&nbsp;", 3) . $record['note'];
        }
        echo "<br>";
    }
}

/**
 * Entry point of the application.
 * 
 * @param string $filename path to the JSON file.
 * @return void
 */
function main(string $filename): void {
    echo "Current time: " . date("Y-m-d H:i:s") . "<br><br>";
    $arrivals = recordArrival($filename);
    printOut($arrivals);
}

main("./logger1.json");