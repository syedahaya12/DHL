<?php
// db.php
// Place this in the root project folder and include it using require_once.

$DB_HOST = 'localhost';
$DB_USER = 'uannmukxu07nw';
$DB_PASS = 'nhh1divf0d2c';
$DB_NAME = 'dbrlpww9ojms0p';
$DB_PORT = 3306; // change if needed

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
if ($mysqli->connect_errno) {
    // do not reveal sensitive info in production
    http_response_code(500);
    echo "Database connection failed. Error: " . $mysqli->connect_error;
    exit;
}
$mysqli->set_charset("utf8mb4");

// helper: safe prepare + execute + get result
function db_query($sql, $types = '', $params = []) {
    global $mysqli;
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("DB Prepare failed: " . $mysqli->error);
    }
    if ($types !== '') {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    return $res;
}
?>
