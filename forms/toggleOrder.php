<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';


$connect = getConnect();
if (mysqli_errno($connect)){
    echo '{"status":"error", "text": "'. mysqli_error($connect) .'"}';
    die();
}

$data = json_decode(file_get_contents('php://input'),true);
$newStatus = mysqli_real_escape_string($connect,$data['newStatus']);
$id = mysqli_real_escape_string($connect,$data['orderId']);


$query = "Update orders set status = $newStatus where id = $id";
$result = mysqli_query($connect, $query);
mysqli_close($connect);

if ($result){
    echo '{"status":"ok"}';
} else {
    echo '{"status":"error"}';
}



