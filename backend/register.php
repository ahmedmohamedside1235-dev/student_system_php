<?php
session_start();
require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/validation.php";
require_once __DIR__ . "/../database/connection.php";

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    throwError(405, "Method Not Allowed");
}

$_SESSION["_errors"] = [];
$_SESSION["_old"] = $_POST;
validate();

$DB = getConnection();
$hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$DB->exec("INSERT INTO 
            students 
            (first_name , last_name , email , password , age , phone)
            VALUES
            ('{$_POST['firstName']}' , '{$_POST['lastName']}' , '{$_POST['email']}' , '{$hashPassword}' , '{$_POST['age']}' , '{$_POST['phone']}')
        ");

unset($_SESSION["_old"]);
redirectTo();
