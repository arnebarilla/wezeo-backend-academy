<?php

/**
 * Records a new arrival to the JSON file.
 * 
 * @param string $filename path to the JSON file.
 * @return array updated list of arrivals.
 * REVIEW - toto je detail ale nie vždy sa ti vráti "updated list of arrivals", lebo ak je po 20:00 tak sa vráti null, čo by teda znamenalo že neexistujú žiadne záznamy príchodov
 * V tomto prípade ti to nič nepokazí ale ak už definuješ také veci ako typ input-u / output-u (čo nie je required samozrejme ale je to fajn robiť) tak by si to mal robiť striktne
 */
function recordArrival(string $filename): ?array {
    $timestamp = date("Y-m-d H:i:s");
    $hour = (int) date("H");
    $minute = (int) date("i");

    // REVIEW - Viac krát tu robíš jeden check - $hour >= alebo <= ako X a zároveň !($hour == X a $minute == 0) - toto by si si mohol oddeliť do nejakej checkTime funkcie
    // Potom by sa ti zjednodušil aj zápis $onTime = checkTime(X) && checkTime(Y)
    if ($hour >= 20 && !($hour == 20 && $minute == 0)) return null;
    $onTime = true;
    if (($hour >= 8 && $hour <= 19 && !($hour == 8 && $minute == 0))
        || ($hour == 20 && $minute == 0)) {
        $onTime = false;
    }

    $arrivals = json_decode(file_get_contents($filename), true) ?? [];

    $record = [
        "time" => $timestamp
    ];

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