<?php
$output = shell_exec('git diff --name-only && git status --porcelain');
file_put_contents(__DIR__ . '/git-status.txt', $output);
