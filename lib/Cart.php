<?php
class Cart extends Database {
  function details ()
  {
    // получаю данные о товарах в корзине

    // если корзина пуста
    if (count($_SESSION['cart']) == 0)
    {
      return false;
    }

    // получаю товары из корзины
    $sql = "SELECT * FROM `products` WHERE `product_id` IN (";
    $sql .= str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
    $sql .= ")";
    return $this->fetch($sql, array_keys($_SESSION['cart']), "product_id");
  }

    function checkout ($name, $email)
  {
    //* оформление и создание нового заказа
    /* 
      параметры:
      $name - имя
      $email -имейл
    */

    // создаю запись заказа в таблице orders
    $pass = $this->exec(
      "
        INSERT INTO `orders` (`order_name`, `order_email`)
        VALUES (?, ?);
      ",
      [$name, $email]
    );

    // добавляю записи в orders_items
    if ($pass)
    {
      $this->order_id = $this->last_id;
      $sql = "INSERT INTO `orders_items` (`order_id`, `product_id`, `quantity`) VALUES ";
      $cond = [];
      foreach ($_SESSION['cart'] as $id => $qty)
      {
        $sql .= "(?, ?, ?),";
        array_push($cond, $this->order_id, $id, $qty);
      }
      $sql = substr($sql, 0, -1) . ";";
      $pass = $this->exec($sql, $cond);
    }

    return $pass;
  }
}