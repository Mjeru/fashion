<?php

function showAllProducts($products){
    foreach ($products as $product){
        ?>
            <li class="product-item page-products__item">
                <b class="product-item__name"><?=$product['name']?></b>
                <span class="product-item__field"><?=$product['id']?></span>
                <span class="product-item__field"><?=$product['price']?> руб.</span>
                <span class="product-item__field"><?=$product['category']?></span>
                <span class="product-item__field"><?=$product['new'] == '1'? 'да' : 'нет'?></span>
                <a href="/add?id=<?=$product['id']?>" class="product-item__edit" aria-label="Редактировать"></a>
                <button data-product_id="<?=$product['id']?>" class="product-item__delete"></button>
            </li>
        <?php
    }
}