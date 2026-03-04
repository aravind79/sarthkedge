<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logos = [
    'horizontal_logo' => 'https://sarthakedge.com/assets/horizontal-logo.svg',
    'vertical_logo' => 'https://sarthakedge.com/assets/vertical-logo.svg',
    'login_page_logo' => 'https://sarthakedge.com/assets/horizontal-logo.svg',
    'favicon' => 'https://sarthakedge.com/assets/favicon.svg'
];

foreach ($logos as $key => $value) {
    \DB::table('system_settings')->updateOrInsert(
        ['name' => $key],
        ['data' => $value, 'type' => 'text']
    );
}

echo "Updating Cache...\n";
app(\App\Services\CachingService::class)->removeSystemCache(config('constants.CACHE.SYSTEM.SETTINGS'));
echo "Done.\n";
