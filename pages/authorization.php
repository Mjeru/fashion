

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Авторизация</title>

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
<?php include_once "./templates/header.php"; ?>
<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
  <form class="custom-form" action="/admin" method="post">
    <input type="email" name="mail" class="custom-form__input" required="">
    <input type="password" name="password" class="custom-form__input" required="">
    <button class="button" type="submit">Войти в личный кабинет</button>
  </form>
</main>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/footer.php";
?>
</body>
</html>
