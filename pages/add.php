<?php

session_start(['name'=>'session_id']);

if (!$_SESSION['auth']) {
    header('Location:/admin');
}

if ($_GET['id']){
    include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/newProduct.php';
} else{
    include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/newEmptyProduct.php';
}

?>

