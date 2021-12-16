<?php
include("../config.php");

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if ($contentType === "application/json") {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

    //collect data
    $id         = $decoded['id'];

    //if there are no errors, carry on
    if (isset($id)) {
        $row = $db->row("SELECT * FROM events where id=?", [$decoded['id']]);
        $data = [
            'id'        => $row->id,
            'title'     => $row->title,
            'start'     => date('Y-m-d H:i:s', strtotime($row->start_event)),
            'end'       => date('Y-m-d H:i:s', strtotime($row->end_event)),
            'color'     => $row->color,
            'textColor' => $row->text_color
        ];
        $data['success'] = true;
    } else {

        $data['success'] = false;
        $data['errors'] = "The ID field can't be Null or empty";
    }

    $resultados = json_encode($data);
    header("Content-Type: application/json; charset=UTF-8");
    echo $resultados;
}
