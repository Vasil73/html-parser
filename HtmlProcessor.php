<?php


    $json = file_get_contents('php://input');
    if ($object = json_decode($json)) {
        $object = $object->raw_text;
    } else {
        http_response_code(500);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $regex = '/<a[^>]*?>(.*?)<\/a>/si';
        $formatted_text = preg_replace($object, '$1', $regex);
        $json = ['formatted_text' => $formatted_text];
        header('Content-Type: application/json');
        echo json_encode($json);
    }

