<div class="container">
    <a href="/profile">Мой профиль</a>
    <a href="/cart">Корзина</a>
    <a href="/user-order">Мои заказы</a>
    <h3>Catalog</h3>
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
                        <a href="#"><h5 class="card-title"><?php echo $product->getDescription(); ?></h5></a>
                        <div class="card-footer">
                            <?php echo $product->getPrice() . '$';?>
                        </div>
                    </div>
                </a>
            </div>
            <form action="/add-product" method="POST">
                <div class="container">
                    <input type="hidden" placeholder="Enter product-id" name="product-id" value="<?php echo $product->getId(); ?>" id="product-id" required>
                    <button type="submit" class="registerbtn">+</button>
                </div>
            </form>
            <form action="/decrease-product" method="POST">
                <div class="container">
                    <input type="hidden" placeholder="Enter product-id" name="product-id" value="<?php echo $product->getId(); ?>" id="product-id" required>
                    <button type="submit" class="registerbtn">-</button>
                </div>
            </form>
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

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>