<?php
require_once __DIR__ . "/../database/connection.php";
require_once __DIR__ . "/helpers.php";
header('Content-Type: application/json; charset=UTF-8');

$page = 1;
$search = "";

if (isset($_POST['pageNumber']) && $_POST['pageNumber'] > 1) {
    $page = $_POST['pageNumber'];
}

if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

$offset = ($page * 10) - 10;
$DB = getConnection();

// get students
$stmt = $DB->query("SELECT 
                            * 
                        FROM 
                        students
                        WHERE
                            CONCAT(first_name, ' ', last_name) LIKE '%{$search}%'
                            OR
                            email LIKE '%{$search}%'
                            OR
                            age LIKE '%{$search}%'
                            OR
                            phone LIKE '%{$search}%'
                        ORDER BY id DESC
                        LIMIT 10 OFFSET {$offset}
                    ;");
$students = $stmt->fetchAll();

// get total students
$countStudent = $DB->query("SELECT COUNT(*) AS total 
                                FROM 
                                    students 
                                WHERE 
                                    first_name LIKE '%{$search}%'
                                    OR
                                    last_name LIKE '%{$search}%'
                                    OR
                                    email LIKE '%{$search}%'
                                    OR
                                    age LIKE '%{$search}%'
                                    OR
                                    phone LIKE '%{$search}%'
                                ");
$total = $countStudent->fetch()['total'];

echo json_encode([
    "students" => $students,
    "currentPage" => (int) $page,
    "totalPages" => (int) ceil($total / 10),
]);
