<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logos = [
    'horizontal_logo' => 'https://sarthakedge.com/assets/web-site-images/logo.png',
    'vertical_logo' => 'https://sarthakedge.com/assets/web-site-images/logo.png',
    'login_page_logo' => 'https://sarthakedge.com/assets/web-site-images/logo.png'
];

foreach ($logos as $key => $value) {
    \DB::table('system_settings')->updateOrInsert(
        ['name' => $key],
        ['data' => $value, 'type' => 'text']
    );
}

echo "Updating Cache...\n";
app(\App\Services\CachingService::class)->removeSystemCache(config('constants.CACHE.SYSTEM.SETTINGS'));
\Artisan::call('cache:clear');
\Artisan::call('view:clear');
\Artisan::call('config:clear');
echo "Done.\n";
