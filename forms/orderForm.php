<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';


$connect = mysqli_connect($host, $user, $password, $database,$port);

if (mysqli_errno($connect)){
    echo '{"status":"error", "text": "'. mysqli_error($connect) .'"}';
    die();
}

$productId = mysqli_real_escape_string($connect,$_POST['prodId']);
$productPrice = mysqli_fetch_assoc(mysqli_query($connect, "select price from products where id = $productId"))['price'];



$params = [
    'surname' => mysqli_real_escape_string($connect,$_POST['surname']) ?? '',
    'name' => mysqli_real_escape_string($connect,$_POST['name']) ?? '',
    'patronymic' => mysqli_real_escape_string($connect,$_POST['patronymic']) ?? '',
    'phone' => mysqli_real_escape_string($connect,$_POST['phone']) ?? '',
    'email' => mysqli_real_escape_string($connect,$_POST['email']) ?? '',
    'delivery' => mysqli_real_escape_string($connect,$_POST['delivery']) == 'dev-yes' ? '1' : '0',
    'city' => mysqli_real_escape_string($connect,$_POST['city']) ?? '',
    'street' => mysqli_real_escape_string($connect,$_POST['street']) ?? '',
    'house' => mysqli_real_escape_string($connect,$_POST['home']) ?? '',
    'apartment' => mysqli_real_escape_string($connect,$_POST['aprt']) ?? '',
    'pay' => mysqli_real_escape_string($connect,$_POST['pay']) ?? '',
    'comment' => mysqli_real_escape_string($connect,$_POST['comment']) ?? '',
    'product' => mysqli_real_escape_string($connect,$_POST['prodId'])   ?? '',
    'price' => mysqli_real_escape_string($connect,$_POST['delivery']) == 'dev-yes' && $productPrice < $minOrderPrice ? $productPrice + $deliveryPrice : $productPrice
];

$columnsStr = implode(",",array_keys($params));
$valuesStr = "'".implode("', '",array_values($params))."'";



$query = "INSERT INTO orders (".$columnsStr.") VALUES (".$valuesStr.")";
$result = mysqli_query($connect, $query);



if($result) {
    echo '{"status":"ok"}';
} else {
    echo '{"status":"error"}';
}

mysqli_close($connect);

die();

