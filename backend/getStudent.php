<?php

require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/../database/connection.php";
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    throwApiError(405, "Method {$_SERVER['REQUEST_METHOD']} is not Allowed");
}

if (!isset($_POST['student_id'])) {
    throwApiError(422, "Unprocessable Entity (Search value is not found)");
}


$DB = getConnection();
$stmt = $DB->query("SELECT * FROM students WHERE id = '{$_POST['student_id']}';");
$result = $stmt->fetch();

echo json_encode([
    "message" => "Successfully",
    "student" => $result
]);
