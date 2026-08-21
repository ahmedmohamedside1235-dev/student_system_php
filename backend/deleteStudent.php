<?php

require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/../database/connection.php";
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    throwApiError(405, "Method {$_SERVER['REQUEST_METHOD']} is Not Allowed");
}


if (!isset($_POST['student_id'])) {
    throwApiError(422, "Unprocessable Entity (Student Id is not found)");
}

$DB = getConnection();
$DB->exec("DELETE FROM students WHERE id = '{$_POST['student_id']}';");
throwApiError(200, "Deleted Successfully");
