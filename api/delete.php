<?php
include("../config.php");

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if ($contentType === "application/json") {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    //Collect Data
    $error      = null;

    if ($decoded != null) {
        $db->deleteById('events', $decoded);
        $data['id'] = $decoded;
        $data['success'] = true;
        $data['message'] = 'Success!';
        $resultados = json_encode($data);
    } else {
        $data['success'] = false;
        $data['errors'] = $error;
        $resultados = json_encode($data);
        header("Content-Type: application/json; charset=UTF-8");
    }
    echo $resultados;
}
