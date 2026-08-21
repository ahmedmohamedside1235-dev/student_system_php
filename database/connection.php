<?php

function getConnection(): PDO
{
    $DSN = "mysql:host=fdb1028.awardspace.net;dbname=4784087_ahmed";
    $USERNAME = "4784087_ahmed";
    $PASSWORD = "Ahmed@25";
    try {
        $DB = new PDO($DSN, $USERNAME, $PASSWORD);
        $DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $DB;
    } catch (PDOException $e) {
        exit("Database Connection Falid : {$e->getMessage()}");
    }
}
