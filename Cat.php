<?php

// Define the log file and the output report file
$logFile = 'ABND.logs';
$reportFile = 'ABND_categorized_error_report.txt';

// Read the log file contents
$logContents = file_get_contents($logFile);
$logEntries = explode(PHP_EOL, $logContents);

// Initialize arrays to categorize errors
$errorCategories = [
    'Critical' => [],
    'Error' => [],
    'Warning' => [],
    'Notice' => [],
    'Info' => [],
    'Debug' => []
];

// Define a function to categorize log entries
function categorizeLogEntry($entry) {
    global $errorCategories;
    
    if (strpos($entry, 'CRITICAL') !== false) {
        $errorCategories['Critical'][] = $entry;
    } elseif (strpos($entry, 'ERROR') !== false) {
        $errorCategories['Error'][] = $entry;
    } elseif (strpos($entry, 'WARNING') !== false) {
        $errorCategories['Warning'][] = $entry;
    } elseif (strpos($entry, 'NOTICE') !== false) {
        $errorCategories['Notice'][] = $entry;
    } elseif (strpos($entry, 'INFO') !== false) {
        $errorCategories['Info'][] = $entry;
    } elseif (strpos($entry, 'DEBUG') !== false) {
        $errorCategories['Debug'][] = $entry;
    }
}

// Iterate through each log entry and categorize it
foreach ($logEntries as $entry) {
    categorizeLogEntry($entry);
}

// Generate the categorized error report
$reportContents = "Laravel Categorized Error Report\n\n";
foreach ($errorCategories as $category => $entries) {
    $reportContents .= "=== $category ===\n";
    $reportContents .= "Total: " . count($entries) . "\n\n";
    foreach ($entries as $entry) {
        $reportContents .= $entry . "\n";
    }
    $reportContents .= "\n";
}

// Write the report to the output file
file_put_contents($reportFile, $reportContents);

echo "Categorized error report generated: $reportFile\n";

?>

