<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/showOrders.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

session_start(['name'=>'session_id']);


$orders = getOrders();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Список заказов</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="preload" href="../fonts/opensans-400-normal.woff2" as="font">
  <link rel="preload" href="../fonts/roboto-400-normal.woff2" as="font">
  <link rel="preload" href="../fonts/roboto-700-normal.woff2" as="font">

  <link rel="icon" href="../img/favicon.png">
  <link rel="stylesheet" href="../css/style.min.css">
  <script src="../js/scripts.js" defer=""></script>
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/adminHeader.php"; ?>

<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <ul class="page-order__list">
      <?php
        showOrders($orders['items']);
      ?>
  </ul>
</main>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/footer.php";
?>
</body>
</html>
