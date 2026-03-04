<?php
$dirs = explode("\n", trim(file_get_contents('/tmp/pub_dirs.txt')));
foreach ($dirs as $dir) {
    if ($dir) {
        file_put_contents("$dir/whatisroot.php", "<?php echo __DIR__;");
    }
}
echo "Done";
