<?php

if (!function_exists("formatLogName")) {
    function formatLogName(string $logName): string
    {
        // Add spaces before capital letters
        $withSpaces = preg_replace('/([a-z])([A-Z])/', '$1 $2', $logName);

        // Capitalize the first letter of each word
        return ucwords($withSpaces);
    }
}


if (!function_exists('logLocalize')) {
    function logLocalize($key, $lang = null)
    {
        //TODO::Return localize key for now, will implement later.

        return $key;
    }
}