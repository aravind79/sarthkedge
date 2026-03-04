<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = \DB::table('system_settings')->pluck('data', 'name');
file_put_contents('logos_out.json', json_encode($settings, JSON_PRETTY_PRINT));
