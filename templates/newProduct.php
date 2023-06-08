<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
$connect = getConnect();
$id = $_GET['id'];
$query = "select * from products where id = $id";
$product = mysqli_fetch_assoc(mysqli_query($connect, $query));
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Добавление товара</title>

    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

    <meta name="theme-color" content="#393939">

    <link rel="preload" href="fonts/opensans-400-normal.woff2" as="font">
    <link rel="preload" href="fonts/roboto-400-normal.woff2" as="font">
    <link rel="preload" href="fonts/roboto-700-normal.woff2" as="font">

    <link rel="icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.min.css">

    <script src="js/scripts.js" defer=""></script>
</head>
<body>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/adminHeader.php"; ?>
<main class="page-add">
    <h1 class="h h--1">Добавление товара</h1>
    <form class="custom-form" action="/pages/add.php" method="post">
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
            <label for="name" class="custom-form__input-wrapper page-add__first-wrapper">
                <input type="text" class="custom-form__input" name="name" id="name" value="<?=$product['name']?>">
                <p class="custom-form__input-label" hidden>
                    Название товара
                </p>
            </label>
            <label for="price" class="custom-form__input-wrapper">
                <input type="text" class="custom-form__input" name="price" id="price" value="<?=$product['price']?>">
                <p class="custom-form__input-label" hidden>
                    Цена товара
                </p>
            </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <input type="checkbox" name="clearPhoto" id="clearPhoto" hidden >
            <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
            <ul class="add-list">
                <li class="add-list__item add-list__item--add" hidden>
                    <input type="file" name="photo" id="product-photo" hidden="">
                    <label for="product-photo">Добавить фотографию</label>
                </li>
                <?php
                  if ($product['image'] !== ''){ ?>
                    <li id="savedPhoto" class="add-list__item add-list__item--active">
                        <img alt="" src="/img/products/<?=$product['image']?>"
                    </li>
                    <?php
                }
                ?>

            </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Раздел</legend>
            <div class="page-add__select">
                <select name="category" class="custom-form__select" multiple="multiple">
                    <option hidden="">Название раздела</option>
                    <option value="female" <?=$product['category'] == 'female' ? 'selected': ''?>>Женщины</option>
                    <option value="male" <?=$product['category'] == 'male' ? 'selected': ''?>>Мужчины</option>
                    <option value="children" <?=$product['category'] == 'children' ? 'selected': ''?>>Дети</option>
                    <option value="access" <?=$product['category'] == 'access' ? 'selected': ''?>>Аксессуары</option>
                </select>
            </div>
            <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?=$product['new'] == '1' ? 'checked': ''?>>
            <label for="new" class="custom-form__checkbox-label">Новинка</label>
            <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?=$product['sale'] == '1' ? 'checked': ''?>>
            <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <button class="button" type="submit">Обновить</button>
    </form>
    <section class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
        </div>
    </section>
</main>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/templates/footer.php";
?>

</body>
</html>

