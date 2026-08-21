<?php

require_once __DIR__ . "/../database/connection.php";

function validate(): void
{
    foreach ($_POST as $field => $value) {
        if ($field !== "student_id") {
            validateRequired($field, $value);
        }
    }

    if (!empty($_SESSION["_errors"])) {
        redirectTo();
        return;
    }

    validateEmail("email", $_POST['email']);
    validatePhone("phone", $_POST['phone']);
    validateAge("age", $_POST['age']);

    if (!empty($_SESSION["_errors"])) {
        redirectTo();
        return;
    }

    validateUnique("email", $_POST["email"], 'students');
    validateUnique("phone", $_POST['phone'], "students");

    if (!empty($_SESSION["_errors"])) {
        redirectTo();
        return;
    }
}
function validateEdit(): void
{
    foreach ($_POST as $field => $value) {

        if ($field !== "password") {
            validateRequired($field, $value);
        }
    }

    if (!empty($_SESSION["_errors"])) {
        redirectTo();
        return;
    }

    validateEmail("email", $_POST['email']);
    validatePhone("phone", $_POST['phone']);
    validateAge("age", $_POST['age']);

    if (!empty($_SESSION["_errors"])) {
        redirectTo();
        return;
    }

    validateUnique("email", $_POST["email"], 'students', $_POST['student_id']);
    validateUnique("phone", $_POST['phone'], "students", $_POST['student_id']);

    if (!empty($_SESSION["_errors"])) {
        redirectTo();
        return;
    }
}


function validateRequired(string $field, string $value)
{
    if ($value === null || trim((string) $value) === "") {
        addError($field, "{$field} is required");
    }
}
function validateEmail(string $field, string $value)
{
    if (empty($value)) {
        return;
    }

    $regex = "/^[A-Za-z_][A-Za-z_0-9\.\-]+@(gmail|yahoo)\.(com|org)$/";

    if (!preg_match($regex, $value)) {
        addError($field, "Please enter a vaild {$field}");
    }
}
function validatePhone(string $field, string $value)
{
    if (empty($value)) {
        return;
    }

    $regex = "/^(02)?01(2|1|5|0)[0-9]{8}$/";

    if (!preg_match($regex, $value)) {
        addError($field, "Please enter {$field} valid EGPhone");
    }
}

function validateUnique(string $field, string $value, string $tableName, ?int $exceptId = null)
{
    if (empty($value)) {
        return;
    }

    $DB = getConnection();
    $stmt = $DB->query("SELECT * 
                            FROM 
                                $tableName 
                            WHERE 
                                $field = '{$value}' 
                            AND 
                                id != '{$exceptId}';");
    $result = $stmt->fetchAll();

    if (!empty($result)) {
        addError($field, "{$field} is already exists");
    }
}


function validateAge(string $field,  string $value)
{
    if (empty($value)) return;

    if ($value <= 10) {
        addError($field, "{$field} must be greater than 10");
    }
}
