<?php
$json = file_get_contents('http://api.alquran.cloud/v1/edition?language=ar&type=tafsir');
$data = json_decode($json, true)['data'];
foreach ($data as $d) {
    echo $d['identifier'] . " - " . $d['name'] . PHP_EOL;
}
