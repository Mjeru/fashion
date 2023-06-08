<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';


$connect = getConnect();
if (mysqli_errno($connect)){
    echo '{"status":"error", "text": "'. mysqli_error($connect) .'"}';
    die();
}

$data = json_decode(file_get_contents('php://input'),true);
$id = mysqli_real_escape_string($connect,$data['productId']);


$query = "delete from products where id = $id";
$oldImage = mysqli_fetch_assoc(mysqli_query($connect,'select image from products where id = ' . $id))['image'];
$result = mysqli_query($connect, $query);

if($result) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/img/products/' . $oldImage)) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/img/products/' . $oldImage);
    }
    echo '{"status":"ok"}';
}  else {
    echo '{"status":"error", "test": "'.mysqli_error($connect).'"}';
}

mysqli_close($connect);