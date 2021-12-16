<?php
include("../config.php");

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if ($contentType === "application/json") {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    //Collect Data
    $error      = null;
    $title      = $decoded['title'];
    $start      = $decoded['startDate'];
    $end        = $decoded['endDate'];
    $color      = $decoded['color'];
    $text_color = $decoded['text_color'];

    //Validation
    if ($title == '') {
        $error['title'] = 'Title is required';
    }
    if ($start == '') {
        $error['start'] = 'Start date is required';
    }
    if ($end == '') {
        $error['end'] = 'End date is required';
    }

    //If there are no errors, carry on
    if (!isset($error)) {

        //Format date
        $start = date('Y-m-d H:i:s', strtotime($start));
        $end = date('Y-m-d H:i:s', strtotime($end));

        $data['success'] = true;
        $data['message'] = 'Success!';

        //Store
        $insert = [
            'title'       => $title,
            'start_event' => $start,
            'end_event'   => $end,
            'color'       => $color,
            'text_color'  => $text_color
        ];
        $db->insert('events', $insert);
    } else {

        $data['success'] = false;
        $data['errors'] = $error;
    }

    $resultados = json_encode($data);
    header("Content-Type: application/json; charset=UTF-8");
    echo $resultados;
}
