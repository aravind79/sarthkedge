<?php
$logPath = storage_path('logs/laravel.log');
if (!file_exists($logPath)) {
    echo "No log file found at $logPath";
    exit;
}

$file = new SplFileObject($logPath, 'r');
$file->seek(PHP_INT_MAX);
$totalLines = $file->key();

// Find the start of the last error entry
$found = false;
for ($i = $totalLines; $i >= 0 && $i > $totalLines - 500; $i--) {
    $file->seek($i);
    $line = $file->current();
    if (preg_match('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/', $line)) {
        if (strpos($line, 'local.ERROR') !== false) {
            $found = true;
            $start = $i;
            break;
        }
    }
}

if ($found) {
    for ($j = $start; $j <= $totalLines; $j++) {
        $file->seek($j);
        echo $file->current();
        if ($j > $start + 100)
            break; // limit to 100 lines per error
    }
} else {
    echo "No ERROR found in last 500 lines.";
}
