<?php
$json = file_get_contents('http://api.alquran.cloud/v1/edition?language=ar&type=quran');
$data = json_decode($json, true)['data'];
foreach ($data as $d) {
    if (strpos($d['identifier'], 'tajweed') !== false || strpos($d['name'], 'tajweed') !== false) {
        echo $d['identifier'] . " - " . $d['name'] . " (" . $d['format'] . ")" . PHP_EOL;
    }
}
