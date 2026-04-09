<?php

/**
 * Records a new arrival to the JSON file.
 * 
 * @param string $filename path to the JSON file.
 * @return array updated list of arrivals.
 */
function recordArrival(string $filename): array {
    $timestamp = date("Y-m-d H:i:s");
    echo "Current time: " . $timestamp . "<br><br>";
    $hour = (int) date("H");
    $minute = (int) date("i");

    $arrivals = json_decode(file_get_contents($filename), true) ?? [];

    if ($hour < 8 || ($hour == 8 && $minute == 0)) {
        $arrivals[] = [
            $timestamp,
        ];  
    }
    else if (($hour >= 8 && $hour <= 19) || ($hour == 20 && $minute == 0)) {
        $arrivals[] = [
            $timestamp,
            "meškanie"
        ];  
    }

    file_put_contents($filename, json_encode($arrivals));

    return $arrivals;
}

/**
 * Prints all arrivals to the browser.
 * 
 * @param array $arrivals list of arrival records.
 * @return void
 */
function printOut(array $arrivals): void {
    echo "Timestamp:" . str_repeat("&nbsp;", 18) . "Note: <br>";
    foreach ($arrivals as $record) {
        echo $record[0];
        if (isset($record[1])) {
            echo str_repeat("&nbsp;", 3) . $record[1];
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
    $arrivals = recordArrival($filename);
    printOut($arrivals);
}

main("./logger1.json");