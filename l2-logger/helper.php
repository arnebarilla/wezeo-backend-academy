<?php

class Helper
{
    // Reads JSON file and returns decoded array or [] if file doesn't exist
    public static function readJson(string $filename): array {
        if (!file_exists($filename)) return [];
        return json_decode(file_get_contents($filename), true) ?? [];
    }

    // Encodes array as JSON and writes it to file
    public static function writeJson(string $filename, array $data): void {
        file_put_contents($filename, json_encode($data));
    }
}