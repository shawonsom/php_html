<?php
header('Content-Type: application/json');

// Get the folder from the 'folder' URL parameter. Default to '.' (current directory) if not set.
$folder = isset($_GET['folder']) ? basename($_GET['folder']) : '.';

// Prevent directory traversal issues and construct the path.
// If the selected folder is the root 'log' directory, use '.'
$logDir = ($folder === '.' || $folder === 'log') ? '.' : './' . $folder;

// Check if the directory actually exists
if (!is_dir($logDir)) {
    // Return a JSON error if the directory doesn't exist
    echo json_encode(['error' => 'Directory not found: ' . $logDir]);
    exit;
}

// Find all files matching the pattern inside the correct directory
$files = glob($logDir . '/*.txt');

// Sort files by modification time, newest first
usort($files, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

// Get the 10 most recent files
$latestFiles = array_slice($files, 0, 10);

// Get just the filenames from the paths
$fileNames = array_map('basename', $latestFiles);

// Return the list of filenames as JSON
echo json_encode($fileNames);