<?php
$file = 'resources/views/remitente/index.blade.php';
$lines = file($file);
$total = count($lines);
echo "Total lines before: $total\n";
// Keep lines 1-367 (indices 0-366) and from line 912 onwards (index 911+)
$keep = array_merge(array_slice($lines, 0, 367), array_slice($lines, 911));
file_put_contents($file, implode('', $keep));
echo "Done. Lines now: " . count($keep) . "\n";
