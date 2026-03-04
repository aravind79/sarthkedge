<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

ini_set('memory_limit', '512M');
$sql = file_get_contents(__DIR__ . '/database_dump.sql');
\DB::unprepared($sql);
echo "Database restored successfully!\n";
