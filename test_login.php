<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$schools = \App\Models\School::get();
echo "Total schools: " . count($schools) . "\n";
foreach ($schools as $s) {
    echo $s->code . " - " . $s->name . " - Status: " . $s->status . ", Installed: " . $s->installed . "\n";
}
