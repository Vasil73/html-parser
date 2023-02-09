<?php

    $json = file_get_contents('php://input');
    $object = json_decode($json);

    if (isset($object)) {
        $object = $object->raw_text;
    } else {
        http_response_code(500);
    }

    if ($_SERVER['REQUEST_METHOD'] === $_POST) {
        $regex = '/\<a\s.*?\>(.*?)\<\/a\>/iums';
        $formatted_text = preg_replace($object, '$1', $regex);
        $json = ['formatted_text' => $formatted_text];
            header('Content-Type: application/json');
             echo json_encode($json);
    }

