<?php


$json = file_get_contents('php://input');
$object = json_decode($json);

if (isset($object)) {
    $object = $object->raw_text;
} else {
    http_response_code(500);
}

if ($_SERVER['REQUEST_METHOD'] === 'post') {
    $regex = '/<a[^>]*?>(.*?)<\/a>/si';  // /<a [^>]*href="(.*)"[^>]*>(.*)<\/a>/
    $str = "";
    $formatted_text = preg_match_all($object, $str, $regex);
    $json = ['formatted_text' => $formatted_text];
    header('Content-Type: application/json');
    echo json_encode($json);
}

