<?php

function showProducts($products)
{
    forEach($products as $product) {
        ?>

        <article class="shop__item product" data-product_id='<?=$product['id']?>' tabindex="0">
            <div class="product__image">
                <img src="/img/products/<?=$product['image']?>" alt="product-name">
            </div>
            <p class="product__name"><?=$product['name']?></p>
            <span class="product__price"><?=$product['price']?> руб.</span>
        </article>
        <?php
    }
}