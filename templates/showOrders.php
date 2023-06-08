<?php
function showOrders($orders)
{
    foreach ($orders as $order){
        ?>
        <li class="order-item page-order__item">
            <div class="order-item__wrapper">
                <div class="order-item__group order-item__group--id">
                    <span class="order-item__title">Номер заказа</span>
                    <span class="order-item__info order-item__info--id"><?=$order['id']?></span>
                </div>
                <div class="order-item__group">
                    <span class="order-item__title">Сумма заказа</span>
                    <?=$order['price']?> руб.
                </div>
                <button class="order-item__toggle"></button>
            </div>
            <div class="order-item__wrapper">
                <div class="order-item__group order-item__group--margin">
                    <span class="order-item__title">Заказчик</span>
                    <span class="order-item__info"><?=$order['name'] .' '. $order['surname'] .' '. $order['patronymic']?></span>
                </div>
                <div class="order-item__group">
                    <span class="order-item__title">Номер телефона</span>
                    <span class="order-item__info"><?=$order['phone']?></span>
                </div>
                <div class="order-item__group">
                    <span class="order-item__title">Способ доставки</span>
                    <span class="order-item__info"><?=$order['delivery'] == 1 ? "Курьером": "Самовывоз" ?></span>
                </div>
                <div class="order-item__group">
                    <span class="order-item__title">Способ оплаты</span>
                    <span class="order-item__info"><?=$order['pay'] == 'cash' ? "Наличными": "Картой" ?></span>
                </div>
                <div class="order-item__group order-item__group--status">
                    <span class="order-item__title">Статус заказа</span>
                    <?php
                    if ($order['status'] == 0) {
                        echo '<span class="order-item__info order-item__info--no">Не выполнено</span>';
                    } else {
                        echo '<span class="order-item__info order-item__info--yes">Выполнено</span>';
                    }
                    ?>
                    <button class="order-item__btn" data-order_id="<?=$order['id']?>">Изменить</button>
                </div>
            </div>
            <?php
            if ($order['delivery']){ ?>
                <div class="order-item__wrapper">
                    <div class="order-item__group">
                        <span class="order-item__title">Адрес доставки</span>
                        <span class="order-item__info"><?='г. ' . $order['city'] .', ул. '. $order['street'] .', д. '. $order['house'] .', кв. '. $order['apartment']?></span>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="order-item__wrapper">
                <div class="order-item__group">
                    <span class="order-item__title">Комментарий к заказу</span>
                    <span class="order-item__info"><?=$order['comment']?></span>
                </div>
            </div>
        </li>
        <?php
    }
}