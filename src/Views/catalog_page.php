<div class="container">
    <ul>
        <li><a href="/profile">Мой профиль</a></li>
        <li><a href="/cart">Корзина</a></li>
        <li><a href="/user-order">Мои заказы</a></li>
    </ul>
    <h2>Каталог</h2>
    <div class="card-deck">
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    Hit!
                </div>
                <?php foreach ($products as $product): ?>
                <img class="card-img-top" src="<?php echo $product->getImageUrl(); ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product->getName(); ?></p>
                    <div class="card-footer">
                        <?php echo $product->getPrice() . '$'; ?>
                    </div>

                    <div style="display: flex; gap: 10px; justify-content: center; margin-top: 10px;">
                        <form action="/get-product" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>" required>
                            <input type="submit" value="О продукте" class="registerbtn">
                        </form>

                        <form action="/add-product" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>" required>
                            <input type="hidden" name="amount" value="1" required>
                            <button type="submit" class="registerbtn">+</button>
                        </form>

                        <form action="/decrease-product" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>" required>
                            <input type="hidden" name="amount" value="1" required>
                            <button type="submit" class="registerbtn">-</button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
        </div>


        <style>
            body {
                font-style: sans-serif;
            }

            a {
                text-decoration: none;
            }

            a:hover {
                text-decoration: none;
            }

            h3 {
                line-height: 3em;
            }

            .card {
                max-width: 16rem;
            }

            .card:hover {
                box-shadow: 1px 2px 10px lightgray;
                transition: 0.2s;
            }

            .card-header {
                font-size: 13px;
                color: gray;
                background-color: white;
            }

            .text-muted {
                font-size: 11px;
            }

            .card-footer {
                font-weight: bold;
                font-size: 18px;
                background-color: white;
            }

        </style>