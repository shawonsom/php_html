<?php
if (isset($_POST['file']) && isset($_POST['keyword']) && isset($_POST['folder'])) {
    $fileName = basename($_POST['file']); // Basic security measure
    $folderName = basename($_POST['folder']);
    $keyword = $_POST['keyword'];

    $dir = ($folderName === '.' || $folderName === 'log') ? '.' : './' . $folderName;
    $filePath = $dir . '/' . $fileName;

    if (file_exists($filePath)) {
        $results = [];
        $handle = fopen($filePath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, $keyword) !== false) {
                    $results[] = $line;
                }
            }
            fclose($handle);
        }
        echo implode("", $results);
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
