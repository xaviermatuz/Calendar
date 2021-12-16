<?php
include("../config.php");

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if ($contentType === "application/json") {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    //collect data
    $error      = null;
    $id         = $decoded['id'];
    $start      = $decoded['start'];
    $end        = $decoded['end'];

    //optional fields
    $title      = isset($decoded['title']) ? $decoded['title'] : '';
    $color      = isset($decoded['color']) ? $decoded['color'] : '';
    $text_color = isset($decoded['text_color']) ? $decoded['text_color'] : '';

    //validation
    if ($start == '') {
        $error['start'] = 'Start date is required';
    }

    if ($end == '') {
        $error['end'] = 'End date is required';
    }

    if ($title == '') {
        $error['title'] = 'Title is required';
    }

    //if there are no errors, carry on
    if (!isset($error)) {

        //reformat date
        $start = date('Y-m-d H:i:s', strtotime($start));
        $end = date('Y-m-d H:i:s', strtotime($end));

        $data['success'] = true;
        $data['message'] = 'Success!';

        //set core update array
        $update = [
            'start_event' => date('Y-m-d H:i:s', strtotime($start)),
            'end_event' => date('Y-m-d H:i:s', strtotime($end))
        ];

        //check for additional fields, and add to $update array if they exist
        if ($title != '') {
            $update['title'] = $title;
        }

        if ($color != '') {
            $update['color'] = $color;
        }

        if ($text_color != '') {
            $update['text_color'] = $text_color;
        }

        //set the where condition ie where id = 2
        $where = ['id' => $id];

        //update database
        $db->update('events', $update, $where);
    } else {

        $data['success'] = false;
        $data['errors'] = $error;
    }

    $resultados = json_encode($data);
    header("Content-Type: application/json; charset=UTF-8");
    echo $resultados;
}
