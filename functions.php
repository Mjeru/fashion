<?php

function getConnect()
{
    static $connect;
    if (empty($connect)){
        include_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
        $connect = mysqli_connect($host, $user, $password, $database);
    }
    return $connect;
}


function getProducts($options) : array
{
    $page = $_GET['page'] ?? 1;
    $conditions = [];
    if (isset($_GET['priceMin']) && isset($_GET['priceMax'])){
//        $new
        array_push($conditions, "price between ".$_GET['priceMin']." and ".$_GET['priceMax']);
        //        $conditions = $condition . "price between ".$_GET['priceMin']." and ".$_GET['priceMax'];
    }
    if (isset($_GET['sale']) && $_GET['sale'] === 'on'){
            array_push($conditions, "sale = 1");
        }
    if (isset($_GET['new']) && $_GET['new'] === 'on'){
            array_push($conditions, "new = 1");
    }
    if (isset($_GET['category']) && $_GET['category'] !== 'all'){
            array_push($conditions, "category = '" . $_GET['category'] . "'");
    }
    $conditions = implode(' and ',$conditions);
    // sorting

    $sorting = '';

    if (isset($_GET['sort']) && $_GET['sort'] !== '' && isset($_GET['order']) && $_GET['order'] !== ''){

        if($_GET['sort'] ==='name'){
            $sorting = 'order by name' . ($_GET['order'] === 'asc' ? ' asc' : ' desc');
        }
        if($_GET['sort'] ==='price'){
            $sorting = 'order by cast(price as decimal)' . ($_GET['order'] === 'asc' ? ' asc' : ' desc');
        }
    }

    



    $connect = getConnect();
    $offset = ($page - 1)*9;
    $sorting = $sorting === '' ? '' : ' ' . $sorting;
    $condQuery = strlen($conditions) > 0 ? " where " . $conditions : "";
    $products = mysqli_query($connect, "select * from products " . $condQuery . $sorting . " limit $offset,9");
    $result = [
        'items' => [],
        'count' => mysqli_fetch_assoc(mysqli_query($connect, "select count(*) from products " . $condQuery))["count(*)"],
    ];
    if ($products){
        while ($product = mysqli_fetch_assoc($products)) {
            array_push($result['items'], $product);
        }
    }
    return $result;
}



function getOrders():array
{
    $connect = getConnect();
    $orders = mysqli_query($connect, "select * from orders");
    $result = [
        'items' => [],
        'count' => 0,
    ];
    if ($orders){
        while ($order = mysqli_fetch_assoc($orders)) {
            array_push($result['items'], $order);
        }
    }
    $result['count'] = count($result['items']);
    mysqli_close($connect);
    return $result;
}


function getAllProducts() : array
{
    $connect = getConnect();
    $products = mysqli_query($connect, "select * from products");
    $result = [];
    if ($products){
        while ($product = mysqli_fetch_assoc($products)) {
            array_push($result, $product);
        }
    }
    return $result;
}

function isCurrentUrl($path): bool {
    return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) == $path;
}

function isActivePath($value): bool {
    return $_SERVER['QUERY_STRING'] == $value['query'] && $_SERVER['REQUEST_URI'] == $value['path'];
}

