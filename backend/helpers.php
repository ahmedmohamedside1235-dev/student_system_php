<?php


function pr(mixed $data, bool $die = false)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    if ($die) {
        exit;
    }
}

function throwError(int $status, string $msg = "")
{
    http_response_code($status);
    exit($msg);
}

function throwApiError(int $status, string | array $msg = "")
{
    http_response_code($status);
    echo json_encode([
        "status" => $status,
        "message" => $msg
    ]);
    exit;
}


function addError(string $field, string $msg)
{
    $_SESSION["_errors"][$field][] = $msg;
}

function  redirectTo()
{
    $path = $_SERVER['HTTP_REFERER'];
    header("location:{$path}");
    exit;
}


function showError(string $key)
{
    $htmlError = "";
    if (isset($_SESSION["_errors"][$key])) {
        $htmlError = "<p class='api-error-banner mb-0'><i class='fa-solid fa-circle-exclamation'></i> {$_SESSION['_errors'][$key][0]}</p>";
        unset($_SESSION['_errors'][$key]);
    }

    return $htmlError;
}


function old(string $key)
{

    $oldValue = $_SESSION['_old'][$key] ?? '';
    unset($_SESSION['_old'][$key]);
    return $oldValue;
}
