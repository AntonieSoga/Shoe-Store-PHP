<?php

function writeLog($message)
{
    $logFilePath = 'logs.html';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "<p>$timestamp: $message</p>\n";

    file_put_contents($logFilePath, $logEntry, FILE_APPEND | LOCK_EX);
}

// Random activities to log
$activities = array(
    "Searched for: 'shoes'",
    "Added 'Nike Air Max' to the cart",
    "Checked out",
    "Updated product with ID 5",
    "Viewed product list"
);

// Generate logs for the current timestamp
writeLog($activities[array_rand($activities)]);

// Generate logs for 2 minutes ago
$twoMinutesAgo = time() - (2 * 60);
$timestampTwoMinutesAgo = date('Y-m-d H:i:s', $twoMinutesAgo);
writeLog("[Timestamp 2 minutes ago]: " . $activities[array_rand($activities)]);

echo "Logs generated successfully!";
?>
