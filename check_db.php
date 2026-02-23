<?php
require_once 'includes/db.php';

try {
    // Attempt to query the database to verify the connection
    $stmt = $pdo->query('SELECT VERSION()');
    $version = $stmt->fetchColumn();
    echo "SUCCESS: Connected to database.\n";
    echo "Database Version: " . $version . "\n";
} catch (\PDOException $e) {
    echo "FAILURE: Could not connect to the database.\n";
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
