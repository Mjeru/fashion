<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/showProducts.php';

//
$options = [
        'page'=>1,
];

$products = getProducts($options);

$categories = [
    [
        'name' =>'Мужчины',
        'value'=>'male'
    ],
    [
        'name' =>'Женщины',
        'value'=>'woman'
    ],
    [
        'name' =>'Дети',
        'value'=>'kids'
    ],
    [
        'name' =>'Аксессуары',
        'value'=>'accessories'
    ]
];

function getCategoryQuery($category): bool{
    return $_GET['category'] == $category;
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Fashion</title>
    <meta content="width=device-width,initial-scale=1.0" name="viewport">
    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

    <meta name="theme-color" content="#393939">

    <link rel="preload" href="../img/intro/coats-2018.jpg" as="image">
    <link rel="preload" href="../fonts/opensans-400-normal.woff2" as="font">
    <link rel="preload" href="../fonts/roboto-400-normal.woff2" as="font">
    <link rel="preload" href="../fonts/roboto-700-normal.woff2" as="font">

    <link rel="icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../css/style.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../js/scripts.js" defer=""></script>
</head>
<body>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/templates/header.php'; ?>
<main class="shop-page">
    <header class="intro">
        <div class="intro__wrapper">
            <h1 class=" intro__title">COATS</h1>
            <p class="intro__info">Collection 2018</p>
        </div>
    </header>
    <section class="shop container">
        <section class="shop__filter filter">
            <form id="filterForm">
                <div class="filter__wrapper">
                    <b class="filter__title">Категории</b>
                    <ul class="filter__list">
                        <li>
                            <a class="filter__list-item <?=!isset($_GET['category']) ? 'active': ''?>" href="/">Все</a>
                        </li>
                        <?php
                        foreach ($categories as $category){
                            ?>
                            <li>
                                <a class="filter__list-item <?=getCategoryQuery($category[value]) ? 'active' : ''?>" href="/?category=<?=$category['value']?>"><?=$category['name']?></a>
                            </li>
                            <?php
                        }
                        ?>

                    </ul>
                </div>
                <div class="filter__wrapper">
                    <b class="filter__title">Фильтры</b>
                    <div class="filter__range range">
                        <span class="range__info">Цена</span>
                        <div class="range__line" aria-label="Range Line"></div>
                        <div class="range__res">
                            <span class="range__res-item min-price">350 руб.</span>
                            <span class="range__res-item max-price">32 000 руб.</span>
                            <input class="priceMin" type="hidden" name="priceMin" >
                            <input class="priceMax" type="hidden" name="priceMax" >
                        </div>
                    </div>
                </div>
                <fieldset class="custom-form__group">
                    <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?=isset($_GET['new']) ? "checked='true'": ''?>>
                    <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
                    <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?=isset($_GET['sale']) ? "checked='true'": ''?>>
                    <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
                </fieldset>
                <button class="button" type="submit" style="width: 100%">Применить</button>
                <?php
                foreach ($_GET as $key => $value) {
	                $key = htmlspecialchars($key);
	                $value = htmlspecialchars($value);
	                if($key == 'category'){
	                    echo "<input type='hidden' name='$key' value='$value'/>";
                    }
                }
                ?>
            </form>
        </section>

        <div class="shop__wrapper">
                            <section class="shop__sorting">
                                <div class="shop__sorting-item custom-form__select-wrapper">
                                        <select class="custom-form__select" name="sort" form="filterForm">
                                            <option value="" hidden="">Сортировка</option>
                                            <option value="price" <?= isset($_GET['sort']) && $_GET['sort'] == 'price' ? "selected" : ''?>>По цене</option>
                                            <option value="name" <?= isset($_GET['sort']) && $_GET['sort'] == 'name' ? "selected" : ''?>>По названию</option>
                                        </select>
                                </div>
                                <div class="shop__sorting-item custom-form__select-wrapper">
                                    <select class="custom-form__select" name="order" form="filterForm">
                                        <option value="" hidden="">Порядок</option>
                                        <option value="asc" <?= isset($_GET['order']) && $_GET['order'] == 'asc' ? "selected" : ''?>>По возрастанию</option>
                                        <option value="desc"<?= isset($_GET['order']) && $_GET['order'] == 'desc' ? "selected" : ''?>>По убыванию</option>
                                    </select>
                                </div>
                                <p class="shop__sorting-res">Найдено <span class="res-sort"><?=$products['count']?></span> моделей</p>
                            </section>
            <section class="shop__list">
                <?php
                showProducts($products['items']);
                ?>
            </section>
            <ul class="shop__paginator paginator">
                <?php
                $page = 1;
                $current = isset($_GET['page']) ? $_GET['page'] : 1;
                do{
                ?>
                <li>
                    <a class="paginator__item" <?=$page==$current ? '' : "href='/?page=" . $page . "'"?>><?=$page?></a>
                </li>
                <?php
                }while ($products['count']/9 > ($page++))
                ?>
            </ul>
        </div>
    </section>
    <section class="shop-page__order" hidden="">
        <div class="shop-page__wrapper">
            <h2 class="h h--1">Оформление заказа</h2>
            <form action="/forms/orderForm.php" method="post" class="custom-form js-order">
                <input type="text" id="prodId" name="prodId" hidden value="">
                <fieldset class="custom-form__group">
                    <legend class="custom-form__title">Укажите свои личные данные</legend>
                    <p class="custom-form__info">
                        <span class="req">*</span> поля обязательные для заполнения
                    </p>
                    <div class="custom-form__column">
                        <label class="custom-form__input-wrapper" for="surname">
                            <input id="surname" class="custom-form__input" type="text" name="surname" required="">
                            <p class="custom-form__input-label">Фамилия <span class="req">*</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="name">
                            <input id="name" class="custom-form__input" type="text" name="name" required="">
                            <p class="custom-form__input-label">Имя <span class="req">*</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="thirdName">
                            <input id="thirdName" class="custom-form__input" type="text" name="patronymic">
                            <p class="custom-form__input-label">Отчество</p>
                        </label>
                        <label class="custom-form__input-wrapper" for="phone">
                            <input id="phone" class="custom-form__input" type="tel" name="phone" required="" pattern="^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$">
                            <p class="custom-form__input-label">Телефон <span class="req">*</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="email">
                            <input id="email" class="custom-form__input" type="email" name="email" required="">
                            <p class="custom-form__input-label">Почта <span class="req">*</span></p>
                        </label>
                    </div>
                </fieldset>
                <fieldset class="custom-form__group js-radio">
                    <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
                    <input id="dev-no" class="custom-form__radio" type="radio" name="delivery" value="dev-no" checked="">
                    <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>
                    <input id="dev-yes" class="custom-form__radio" type="radio" name="delivery" value="dev-yes">
                    <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
                </fieldset>
                <div class="shop-page__delivery shop-page__delivery--no">
                    <table class="custom-table">
                        <caption class="custom-table__title">Пункт самовывоза</caption>
                        <tr>
                            <td class="custom-table__head">Адрес:</td>
                            <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Время работы:</td>
                            <td>пн-вс 09:00-22:00</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Оплата:</td>
                            <td>Наличными или банковской картой</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Срок доставки: </td>
                            <td class="date">13 декабря—15 декабря</td>
                        </tr>
                    </table>
                </div>
                <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
                    <fieldset class="custom-form__group">
                        <legend class="custom-form__title">Адрес</legend>
                        <p class="custom-form__info">
                            <span class="req">*</span> поля обязательные для заполнения
                        </p>
                        <div class="custom-form__row">
                            <label class="custom-form__input-wrapper" for="city">
                                <input id="city" class="custom-form__input" type="text" name="city">
                                <p class="custom-form__input-label">Город <span class="req">*</span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="street">
                                <input id="street" class="custom-form__input" type="text" name="street">
                                <p class="custom-form__input-label">Улица <span class="req">*</span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="home">
                                <input id="home" class="custom-form__input custom-form__input--small" type="text" name="home">
                                <p class="custom-form__input-label">Дом <span class="req">*</span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="aprt">
                                <input id="aprt" class="custom-form__input custom-form__input--small" type="text" name="aprt">
                                <p class="custom-form__input-label">Квартира <span class="req">*</span></p>
                            </label>
                        </div>
                    </fieldset>
                </div>
                <fieldset class="custom-form__group shop-page__pay">
                    <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>
                    <input id="cash" class="custom-form__radio" type="radio" name="pay" value="cash">
                    <label for="cash" class="custom-form__radio-label">Наличные</label>
                    <input id="card" class="custom-form__radio" type="radio" name="pay" value="card" checked="">
                    <label for="card" class="custom-form__radio-label">Банковской картой</label>
                </fieldset>
                <fieldset class="custom-form__group shop-page__comment">
                    <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>
                    <textarea class="custom-form__textarea" name="comment"></textarea>
                </fieldset>
                <button class="button" type="submit">Отправить заказ</button>
            </form>
        </div>
    </section>
    <section class="shop-page__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Спасибо за заказ!</h2>
            <p class="shop-page__end-message">Ваш заказ успешно оформлен, с вами свяжутся в ближайшее время</p>
            <button class="button">Продолжить покупки</button>
        </div>
    </section>
</main>

<?php
 include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/footer.php";
?>

</body>
</html>
