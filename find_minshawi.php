<?php
$json = file_get_contents('http://api.alquran.cloud/v1/edition?format=audio&language=ar');
$data = json_decode($json, true)['data'];
foreach ($data as $d) {
    if (stripos($d['identifier'], 'minshawi') !== false || stripos($d['name'], 'minshawi') !== false) {
        echo $d['identifier'] . " - " . $d['name'] . " (" . $d['format'] . ")" . PHP_EOL;
    }
}
