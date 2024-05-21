<?php

header('Content-Type: application/json');

if ($isOptions == 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit;
}

// Determine the request method
$allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'];
if (!in_array($requestMethod, $allowedMethods)) {
    echo "Method not allowed\n";
    header("HTTP/1.1 405 Method Not Allowed");
    exit;
}

$params = [];

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

if ($requestMethod == 'GET') {
    $params = new \ArrayObject($_GET, \ArrayObject::ARRAY_AS_PROPS);
}

if (stripos($contentType, 'application/json') !== false) {
    $jsonInput = file_get_contents('php://input');
    if (!empty($jsonInput)) {
        $data = json_decode($jsonInput, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $params = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Invalid JSON body']);
            exit;
        }
    }
}

if (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
    if (in_array($requestMethod, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
        $rawInput = file_get_contents('php://input');
        parse_str($rawInput, $parsedParams);
        $params = new \ArrayObject($parsedParams, \ArrayObject::ARRAY_AS_PROPS);
    } else {
        $params = new \ArrayObject($_POST, \ArrayObject::ARRAY_AS_PROPS);
    }
}