<?php


session_start(['name'=>'session_id']);

if ($_SESSION['userType'] == 'admin'){

    include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/showProductsEdit.php';


$products = getAllProducts();



?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Товары</title>

    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">
    <meta name="theme-color" content="#393939">
    <link rel="preload" href="../fonts/opensans-400-normal.woff2" as="font">
    <link rel="preload" href="../fonts/roboto-400-normal.woff2" as="font">
    <link rel="preload" href="../fonts/roboto-700-normal.woff2" as="font">
    <link rel="icon" href="/img/favicon.png">
    <link rel="stylesheet" href="../css/style.min.css">

    <script src="../js/scripts.js" defer=""></script>
</head>
<body>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/adminHeader.php"; ?>
<main class="page-products">
    <h1 class="h h--1">Товары</h1>
    <a class="page-products__button button" href="/add">Добавить товар</a>
    <div class="page-products__header">
        <span class="page-products__header-field">Название товара</span>
        <span class="page-products__header-field">ID</span>
        <span class="page-products__header-field">Цена</span>
        <span class="page-products__header-field">Категория</span>
        <span class="page-products__header-field">Новинка</span>
    </div>
    <ul class="page-products__list">
        <?php
        showAllProducts($products)
        ?>
    </ul>
</main>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/footer.php";
?>
</body>
</html>
<?php

} else {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/pages/authorization.php';
}


