<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mysql_host = config('database.connections.mysql.host');
$mysql_port = config('database.connections.mysql.port');
$mysql_db = config('database.connections.mysql.database');

$school_host = config('database.connections.school.host');
$school_port = config('database.connections.school.port');
$school_db = config('database.connections.school.database');

echo "MySQL: host=$mysql_host port=$mysql_port db=$mysql_db\n";
echo "School: host=$school_host port=$school_port db=$school_db\n";

try {
    Illuminate\Support\Facades\DB::connection('mysql')->select('select 1');
    echo "MySQL connection OK\n";
} catch (\Exception $e) {
    echo "MySQL connection failed: " . $e->getMessage() . "\n";
}

try {
    Illuminate\Support\Facades\DB::connection('school')->select('select 1');
    echo "School connection OK\n";
} catch (\Exception $e) {
    echo "School connection failed: " . $e->getMessage() . "\n";
}
