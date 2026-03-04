<?php
$f = fopen(__DIR__ . '/storage/logs/laravel.log', 'r');
if (!$f)
    die("Cannot open");
fseek($f, -20000, SEEK_END);
$content = stream_get_contents($f);
fclose($f);
file_put_contents(__DIR__ . '/getLastLog.txt', $content);
