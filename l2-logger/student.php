<?php
require_once('helper.php');

class Student
{
    /**
     * Creates a new student record if one does not already exist.
     * If the student name is already in students.json, does nothing.
     *
     * @param string $pathStudents path to students.json
     * @param string $current      name of the student to initialize
     */
    public static function initStudent(string $pathStudents, string $current): void {
        $students = Helper::readJson($pathStudents);
        
        foreach ($students as $student) {
            if ($student['student'] == $current) return;
        }
        
        $students[] = [
            "student" => $current,
            "arrivalsCount" => 0
        ];
        
        Helper::writeJson($pathStudents, $students);
    }

    /**
     * Increments the arrival count for the given student.
     *
     * @param string $pathStudents path to students.json
     * @param string $current      name of the student
     */
    public static function incrArrivalCount(string $pathStudents, string $current): void {
        $students = Helper::readJson($pathStudents);

        foreach ($students as &$student) {
            if ($student['student'] == $current) {
                $student['arrivalsCount']++;
                break;
            }
        }

        Helper::writeJson($pathStudents, $students);
    }

    /**
     * Outputs the total number of arrivals for the given student.
     *
     * @param string $pathStudents path to students.json
     * @param string $current      name of the student
     */
    public static function showArrivalCount(string $pathStudents, string $current): void {
        $students = Helper::readJson($pathStudents);

        foreach ($students as &$student) {
            if ($student['student'] == $current) {
                echo "Total number of arrivals: " . $student['arrivalsCount'] . "<br>";
                return;
            }
        }
    }
}