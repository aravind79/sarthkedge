<?php
$lines = file('storage/logs/laravel.log');
file_put_contents('err_output.txt', implode("", array_slice($lines, -50)));
