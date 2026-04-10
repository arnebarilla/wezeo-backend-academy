<?php
require_once('helper.php');

class Arrival 
{
    /**
     * Records a new arrival for the given student.
     * Arrivals are only accepted between 00:00 and 20:00.
     * Arrivals at or before 08:00 are marked as on time, after 08:00 as late.
     *
     * @param string $pathArrivals path to arrivals.json
     * @param string $current      name of the logged-in student
     * @return bool true if the arrival was saved, false if outside the allowed time window
     */
    public static function recordArrival(string $pathArrivals, string $current): bool {
        $arrivals = Helper::readJson($pathArrivals);

        $hour = (int) date("H");
        $minute = (int) date("i");
        if ($hour > 20 || ($hour == 20 && $minute > 0))
            return false;

        $onTime = false;
        if ($hour < 8 || ($hour == 8 && $minute == 0)) {
            $onTime = true;
        }

        $arrivals[] = [
            "time" => date("Y-m-d H:i:s"),
            "student" => $current,
            "onTime" => $onTime
        ];

        Helper::writeJson($pathArrivals, $arrivals);
        return true;
    }

    /** Outputs an HTML table of all recorded arrivals, ordered oldest to newest.
     * @param string $pathArrivals path to arrivals.json
     */
    public static function showArrivals(string $pathArrivals): void {
        $arrivals = Helper::readJson($pathArrivals);

        echo "<table style='border-collapse: collapse;'>";
        echo "<tr>
            <th style='text-align: left; padding-right: 20px;'>Timestamp</th>
            <th style='text-align: left; padding-right: 20px;'>Student</th>
            <th style='text-align: left;'>Note</th>
        </tr>";

        foreach ($arrivals as $arrival) {
            $note = $arrival['onTime'] ? 'On time' : 'Late arrival';
            echo "<tr>";
            echo "<td style='padding-right: 20px;'>" . htmlspecialchars($arrival['time']) . "</td>";
            echo "<td style='padding-right: 20px;'>" . htmlspecialchars($arrival['student']) . "</td>";
            echo "<td>" . htmlspecialchars($note) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}