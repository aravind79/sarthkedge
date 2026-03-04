<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$texts = [
    'hero_title_1' => 'Opt for SarthakEdge 14+ robust features for an enhanced educational experience.',
    'about_us_description' => 'SarthakEdge is the pinnacle of school management, offering advanced technology, user-friendly features, and personalized solutions. It simplifies communication, streamlines administrative tasks, and elevates the educational experience for all stakeholders. With SarthakEdge, excellence in education management is guaranteed.',
    'tag_line' => 'Transform School Management With SarthakEdge',
    'hero_description' => 'Experience the future of education with our SarthakEdge platform. Streamline attendance, assignments, exams, and more. Elevate your school\'s efficiency and engagement.',
    'system_name' => 'SarthakEdge - School Management System',
    'short_description' => 'SarthakEdge - Manage Your School',
];

foreach ($texts as $key => $value) {
    \DB::table('system_settings')->updateOrInsert(
        ['name' => $key],
        ['data' => $value, 'type' => 'text']
    );
}

// Replace 'eSchool' with 'SarthakEdge' in other templates if any
$all_settings = \DB::table('system_settings')->get();
foreach ($all_settings as $setting) {
    if (strpos($setting->data, 'eSchool') !== false) {
        $newData = str_replace('eSchool', 'SarthakEdge', $setting->data);
        \DB::table('system_settings')->where('id', $setting->id)->update(['data' => $newData]);
    }
}

echo "Updating Cache...\n";
app(\App\Services\CachingService::class)->removeSystemCache(config('constants.CACHE.SYSTEM.SETTINGS'));
\Artisan::call('cache:clear');
echo "Done.\n";
