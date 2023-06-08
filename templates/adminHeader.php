<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
$menu = [
    [
        "name" => "Главная",
        'path' => "/"
    ],
    [
        'name' => "Товары",
        'path' => "/products",
    ],
    [
        'name' => "Заказы",
        'path' => "/orders",
    ],
    [
        'name' => "Выйти",
        'path' => "/admin?login=esc"
    ],

];


?>

<header class="page-header">

    <a class="page-header__logo" href="/">
        <img src="../img/logo.svg" alt="Fashion">
    </a>
    <nav class="page-header__menu">
        <ul class="main-menu main-menu--header">

            <?php
            foreach ($menu as $key=>$value){
            ?>
                <li>
                    <a class="main-menu__item <?=isActivePath($value)?"active":""?>" href="<?=$value['path']?>"><?=$value['name']?></a>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>
</header>
