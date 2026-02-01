<?php
$url = 'https://www.islamcan.com/audio/adhan/azan1.mp3';
$headers = get_headers($url);
print_r($headers);
