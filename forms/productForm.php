<?php


include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

$connect = getConnect();
if (mysqli_errno($connect)){
    echo '{"status":"error", "text": "'. mysqli_error($connect) .'"}';
    die();
}


$params = [
    'name' => mysqli_real_escape_string($connect,$_POST['name']) ?? '',
    'price' => mysqli_real_escape_string($connect,$_POST['price']) ?? '',
    'category' => mysqli_real_escape_string($connect,$_POST['category']) ?? '',
    'sale' => isset($_POST['sale']) ? $_POST['sale'] == 'on' ? 1 : 0 : 0,
    'new' => isset($_POST['new']) ? $_POST['new'] == 'on' ? 1 : 0 : 0,

];

if (empty($params['name']) ||
    empty($params['price']) ||
    (!$_POST['oldPhoto'] && ($_FILES['photo']['size'] === 0))){
    echo '{"status":"error", "text": "Поля \'Название\', \'Цена\', \'Картинка\' не должны быть пустыми"}';
    die();
}


if ($_FILES['photo']['size'] > 0) {
    $types = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "image/webp",
    ];
    $upload = $_SERVER["DOCUMENT_ROOT"] . "/img/products/";
    $fType = mime_content_type($_FILES["photo"]["tmp_name"]);
    $typeStr = str_replace('image/','.', $fType);
    if (in_array($fType, $types) && $_FILES['photo']['size'] <= 5242880 ){
        $newFileName = uniqid();
        move_uploaded_file($_FILES["photo"]["tmp_name"],  $upload . $newFileName. $typeStr);
        $params['image'] = $newFileName.$typeStr;
    } else {
        $error = true;
    }
} else {
  if ($_POST['clearPhoto'] == 'on'){
      $params['image'] = null;
  }
}

$columnsStr = implode(",",array_keys($params));
$valuesStr = "'".implode("', '",array_values($params))."'";

$query = '';
if ($_GET['id']){
    $id = $_GET['id'];
    $arr = [];
    foreach ($params as $key=>$value){
        array_push($arr, $key." = '".$value."'");
    };
    $arr = implode(' ,',$arr);
    $query = "update products set ".$arr." where id = $id";
    $oldImage = mysqli_fetch_assoc(mysqli_query($connect,'select image from products where id = ' . $_GET['id']))['image'];
    $result = mysqli_query($connect, $query);
    if($result) {
        if (!$_POST['oldPhoto'] && $oldImage && file_exists($_SERVER['DOCUMENT_ROOT'] . '/img/products/' . $oldImage)){
            unlink($_SERVER['DOCUMENT_ROOT'] . '/img/products/' . $oldImage);
        }
        echo '{"status":"ok", "text": "Товар успешно обновлен"}';
    } else {
        echo '{"status":"error", "text": "'. mysqli_error($connect) .'"}';
    }
} else {
    $query = "insert into products (".$columnsStr.") VALUES (".$valuesStr.")";
    $result = mysqli_query($connect, $query);
    if($result) {
        echo '{"status":"ok","text": "Товар успешно добавлен"}';
    } else {
        echo '{"status":"error", "text": "'. mysqli_error($connect) .'"}';
    }
}

mysqli_close($connect);