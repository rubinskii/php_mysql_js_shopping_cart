<h1>Ваша Корзина</h1>
  <table id="cart-table">
    <tr>
      <th>Удалить</th>
      <th>Количество</th>
      <th>Товар</th>
      <th>Цена</th>
    </tr>
    <?php if(count($_SESSION['cart']) > 0): ?>
      <?php foreach($_SESSION['cart'] as $id => $qty): ?>
        <?php
          $sub = $qty * $products[$id]['product_price'];
          $total += $sub;
        ?>
        <tr>
          <td>
            <input
              type="button"
              class="cart-remove"
              value="X"
              onclick="cart.remove(<?= $id ?>);"
            >
          </td>
          <td>
            <input
              type='number'
              id='qty_<?= $id ?>'
              value='<?= $qty ?>'
              onchange='cart.change(<?= $id ?>);'  
            >
          </td>
          <td>
            <?= $products[$id]['product_name'] ?></td>
          <td>
            <?= $sub ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
        <tr>
          <td colspan="3">Корзина пуста</td>
        </tr>
    <?php endif; ?>
    <tr>
      <td colspan="2"></td>
      <td><strong>Общая сумма</strong></td>
      <td><strong><?=  $total ?></strong></td>
    </tr>
  </table>
    <?php if (count($_SESSION['cart']) > 0) : ?>
    <h3>Оформление заказа</h3>
    <form id="cart-checkout" onsubmit="return cart.checkout();">
      <label>
        Имя и Фамилия
        <input
        type="text"
        id="co_name"
        placeholder="Как к вам обращаться"
        required
        >
      </label>
      <label>
        Электронная почта
        <input
          type="email"
          id="co_email"
          placeholder="Ваш имейл"
          required
        >
      </label>
      <input type="submit" value="Оформить заказ"/>
    </form>
<?php endif; ?>