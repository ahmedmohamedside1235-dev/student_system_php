<?php
session_start();
unset($_SESSION['status'], $_SESSION['_old'], $_SESSION['_errors']);
header("Location: ../index.php");
exit;
