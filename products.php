<?php
require_once  "lib/config.php";
require_once "lib/Database.php";
require_once "lib/Products.php";
$pdt = new Products();
/*
  выполняю запрос SELECT
*/
$products = $pdt->get();
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Простая корзина товаров</title>
  <link rel="stylesheet" href="index.css">
  <script src="index.js"></script>
</head>
<body>
<header id="page-header">
  Простая корзина товаров
  <div id="page-cart-icon" onclick="cart.toggle();">
    &#128722; <span id="page-cart-count">0</span>
  </div>
</header>
<div id="page-products">
<?php if(is_array($products)): ?>
  <?php foreach ($products as $id => $row): ?>
  <div class="pdt">
    <img
      src="images/<?= $row['product_image'] ?>"
      class="pdt-img"
    >
    <h3 class="pdt-name">
      <?= $row['product_name'] ?>
    </h3>
    <div class="pdt-price">
      <?= $row['product_price'] ?> руб.
    </div>
    <div class="pdt-desc">
      <?= $row['product_desc'] ?>
    </div>
    <input
      type="button"
      class="pdt-add"
      value="Добавить"
      onclick="cart.add(<?= $row['product_id'] ?>);"
    >
  </div>
  <?php endforeach; ?>
<?php else: ?>
    Товары не найдены!
<?php endif; ?>
</div>
<div id="page-cart" class="ninja"></div>
</body>
</html>
