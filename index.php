<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';


if (isCurrentUrl("/")) {
    include $_SERVER["DOCUMENT_ROOT"] . '/pages/main.php';
}
if (isCurrentUrl("/delivery")) {
    include $_SERVER["DOCUMENT_ROOT"] . '/pages/delivery.php';
}
if (isCurrentUrl("/add")) {
    include $_SERVER["DOCUMENT_ROOT"] . '/pages/add.php';
}
if (isCurrentUrl("/admin")) {
    include $_SERVER["DOCUMENT_ROOT"] . '/pages/admin.php';
}
if (isCurrentUrl("/orders")) {
    include $_SERVER["DOCUMENT_ROOT"] . '/pages/orders.php';
}
if (isCurrentUrl("/products")) {
    include $_SERVER["DOCUMENT_ROOT"] . '/pages/products.php';
}
