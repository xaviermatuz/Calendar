<?php
include("../config.php");

if (isset($_POST['title'])) {

    //Collect Data
    $error      = null;
    $title      = $_POST['title'];
    $start      = $_POST['startDate'];
    $end        = $_POST['endDate'];
    $color      = $_POST['color'];
    $text_color = $_POST['text_color'];

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

    echo json_encode($data);
}
