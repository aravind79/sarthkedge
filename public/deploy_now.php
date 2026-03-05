<?php
// ============================================================
// DEPLOY SCRIPT - DELETE THIS FILE AFTER USE!
// Access: sarthakedge.com/deploy_now.php?token=deploy2025
// ============================================================

if (!isset($_GET['token']) || $_GET['token'] !== 'deploy2025') {
    die('Unauthorized.');
}

$output = [];

// Find the project root (one level up from public)
$projectRoot = dirname(__DIR__);

echo "<pre style='background:#111;color:#0f0;padding:20px;font-size:13px;'>";
echo "=== SARTHAKEDGE DEPLOY SCRIPT ===\n";
echo "Project Root: " . $projectRoot . "\n\n";

// Function to run command and capture output
function runCmd($cmd, $cwd = null)
{
    $descriptors = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ];
    $process = proc_open($cmd, $descriptors, $pipes, $cwd);
    if (!is_resource($process)) {
        return "ERROR: Could not start process";
    }
    fclose($pipes[0]);
    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($process);
    return trim($stdout . ($stderr ? "\nSTDERR: " . $stderr : ''));
}

// 1. Git pull
echo "--- [1] git pull origin main ---\n";
$result = runCmd('git pull origin main 2>&1', $projectRoot);
echo $result . "\n\n";
flush();

// 2. Composer install (skip dev, no scripts that need tty)
// echo "--- [2] composer install ---\n";
// $result = runCmd('composer install --no-dev --no-interaction 2>&1', $projectRoot);
// echo $result . "\n\n";
// flush();

// 3. Cache clear
echo "--- [2] cache:clear ---\n";
$result = runCmd('php artisan cache:clear 2>&1', $projectRoot);
echo $result . "\n\n";
flush();

// 4. Config clear
echo "--- [3] config:clear ---\n";
$result = runCmd('php artisan config:clear 2>&1', $projectRoot);
echo $result . "\n\n";
flush();

// 5. View clear
echo "--- [4] view:clear ---\n";
$result = runCmd('php artisan view:clear 2>&1', $projectRoot);
echo $result . "\n\n";
flush();

// 6. Route clear
echo "--- [5] route:clear ---\n";
$result = runCmd('php artisan route:clear 2>&1', $projectRoot);
echo $result . "\n\n";
flush();

// 7. Config cache (optional - speeds up app)
echo "--- [6] config:cache ---\n";
$result = runCmd('php artisan config:cache 2>&1', $projectRoot);
echo $result . "\n\n";
flush();

echo "=== DONE! ===\n";
echo "IMPORTANT: Delete this file from your server (public/deploy_now.php) now!\n";
echo "</pre>";
