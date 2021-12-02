<?php
include("../config.php");

if (isset($_POST["id"])) {
    $db->deleteById('events',$_POST['id']);
    $data['id'] = $_POST['id'];
    $data['success'] = true;    
    $data['message'] = 'Success!';
    echo json_encode($data);
}
else {
    $data['success'] = false;
    $data['errors'] = $error;
    echo json_encode($data);
}
