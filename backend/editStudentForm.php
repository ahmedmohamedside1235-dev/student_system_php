<?php

session_start();
require_once __DIR__ . "/validation.php";
require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/../database/connection.php";


if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    throwApiError(405, "Method {$_SERVER['REQUEST_METHOD']} is not Allowed");
}

if (!isset($_POST['student_id'])) {
    throwApiError(422, "Unprocessable Entity (Student Id is not found)");
}


$_SESSION["_errors"] = [];
$_SESSION["_old"] = $_POST;
$_SESSION["status"] = "Edit";
validateEdit();

$queryPassword = "";

if (isset($_POST['password']) && !empty($_POST['password'])) {
    $hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $queryPassword = "password = '{$hashPassword}',";
}

$DB = getConnection();
$DB->exec("UPDATE students SET 
            first_name = '{$_POST['firstName']}',
            last_name = '{$_POST['lastName']}',
            email = '{$_POST['email']}',
            {$queryPassword}
            age = '{$_POST['age']}',
            phone = '{$_POST['phone']}'
            WHERE id = '{$_POST['student_id']}'
            ");

session_unset();
redirectTo();
