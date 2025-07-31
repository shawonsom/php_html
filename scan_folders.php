<?php
header('Content-Type: application/json');

$logDir = '.'; // Current directory
// Get all directories
$folders = array_filter(glob($logDir . '/*'), 'is_dir');
// Add the root log directory to the list
array_unshift($folders, $logDir);

// Extract just the folder names
$folderNames = array_map('basename', $folders);

echo json_encode($folderNames);
