<div class="app">
    <div class="top">
        <div class="section-title">
            <h2>Ваша корзина</h2>
        </div>
        <div class="price">
            <p class="price-title">
                Итоговая стоимость:
            </p>
            <p class="price-amount">
                <?php echo '$' . $sum; ?>
            </p>
        </div>
    </div>
    <div class="cart-list">
        <?php foreach ($products as $product): ?>
        <div class="cart-item">
            <div class="item-image">
                <img src='<?php echo $product->getProduct()->getImageUrl(); ?>' alt="">
            </div>
            <div class="item-info">
                <h3 class="item-title"><?php echo $product->getProduct()->getName(); ?></h3>
                <p class="price-amount"><?php echo '$' . $product->getProduct()->getPrice(); ?></p>
                <?php $res = $product->getProduct(); ?>
                <form action="/add-product" method="POST">
                    <div class="container">
                        <input type="hidden" placeholder="Enter product_id" name="product_id" value="<?php echo $res->getId(); ?>" id="product_id" required>
                        <button type="submit" class="registerbtn">+</button>
                    </div>
                    <div>
                        <input type="hidden" placeholder="Enter amount" name="amount" value="1" id="amount" required>
                    </div>
                </form>
                <?php echo 'Количество: ' . $product->getAmount(); ?>
                <form action="/decrease-product" method="POST">
                    <div class="container">
                        <input type="hidden" placeholder="Enter product_id" name="product_id" value="<?php echo $res->getId(); ?>" id="product_id" required>
                        <input type="hidden" placeholder="Enter amount" name="amount" value="1" id="amount" required>
                        <button type="submit" class="registerbtn">-</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
        <button class="button button-pay"><a href="/create-order">Оформить заказ</a></button>


<!--    </div>-->
</div>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap");
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #3949AB;
        height: 100vh;
    }

    .app {
        font-family: "Open Sans", sans-serif;
        background: #fff;
        border: 2px solid rgba(#000, 0.2);
        border-radius: 20px;
        width: 350px;
        height: 700px;
        display: flex;
        flex-direction: column;
        -webkit-box-shadow: 6px 11px 23px 0px rgba(0, 0, 0, 0.3);
        -moz-box-shadow: 6px 11px 23px 0px rgba(0, 0, 0, 0.3);
        box-shadow: 6px 11px 23px 0px rgba(0, 0, 0, 0.3);
    }

    .top {
        background: #fff;
        display: flex;
        flex-direction: row;
        height: 5em;
        width: 100%;
        padding: 25px;
        justify-content: space-between;
        align-items: flex-start;
        border-radius: 20px 20px 0px 0px;
        .section-title {
        }
        .price {
            text-align: right;

            &-title {
                color: #ccc;
                font-weight: 600;
            }

            &-amount {
                margin-top: 5px;
                font-weight: 700;
            }
        }
    }
    .cart-list {
        font-family: "Open Sans";
        display: flex;
        flex-direction: column;
        padding: 25px;
        height: 100%;
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            img {
                width: 100px;
                border-radius: 5px;
            }
            .item-info {
                text-align: right;
                .price-amount {
                    color: #424242;
                    margin-top: 20px;
                    font-weight: 600;
                }
            }
        }
    }

    .navigate {
        display: flex;
        padding: 25px;

        .button {
            font-family: "Open Sans", sans-serif;
            padding: 20px 10px;
            border: 0;
            border-radius: 20px;

            &-back {
                width: 50px;
                font-size: 24px;
                color: #dedede;
            }
            &-pay {
                margin-left: 10px;
                background: #ff9100;
                color: #fff;
                font-size:1.1em;
                font-weight: 600;
                flex: 1;
            }
        }
    }

</style>