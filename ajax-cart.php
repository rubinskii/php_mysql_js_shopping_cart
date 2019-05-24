<?php
/*
  корзина хранится в сессии
  $_SESSION['cart'][айди товара] = [количество товара]
*/
require_once "lib/config.php";

switch ($_POST['req'])
{
  //* добавить товар
  case "add":
    if (is_numeric($_SESSION['cart'][$_POST['product_id']]))
    {
      $_SESSION['cart'][$_POST['product_id']] ++;
    }
    else
    {
      $_SESSION['cart'][$_POST['product_id']] = 1;
    }
    echo "Товар добавлен";
    break;

  //* подсчёт общего кол-ва товаров
  case "count":
    $total = 0;
    if (count($_SESSION['cart']) > 0)
    {
      foreach ($_SESSION['cart'] as $id => $qty)
      {
        $total += $qty;
      }
    }
    echo $total;
    break;

  //* показать корзину
  case "show":
    require_once "lib/Database.php";
    require_once "lib/Cart.php";
    $cart = new Cart();
    $products = $cart->details();
    $sub = 0;
    $total = 0;
    require_once 'template-ajax-show.php'
;   break;

  //* изменить количество
  case "change":
    if ($_POST['qty'] == 0)
    {
      unset($_SESSION['cart'][$_POST['product_id']]);
    }
    else
    {
      $_SESSION['cart'][$_POST['product_id']] = $_POST['qty'];
    }
    echo "Количество обновлено";
    break;

  //*  оформление заказа
  // todo нет проверок безопасности
  case "checkout":
    require_once "lib/Database.php";
    require_once "lib/Cart.php";
    $cart = new Cart();
    if ($cart->checkout($_POST['name'], $_POST['email']))
    {
      $_SESSION['cart'] = [];
      echo "OK";
    }
    else
    {
      echo $cart->error;
    }
    break;

  //* оформление с отправкой имейла
  case "checkout-email":
    require_once "lib/Database.php";
    require_once "lib/Cart.php";
    $cartLib = new Cart();
    if ($cartLib->checkout($_POST['name'], $_POST['email']))
    {
      $_SESSION['cart'] = [];
      // ! Отформатировать по потребностям
      $order = $cart->get($cart->order_id);
      $to = $_POST['email'];
      $subject = "Заказ получен";
      $message = "";
      foreach ($order['items'] as $pid=>$p) {
        $message .= $p['product_name'] . " - " . $p['quantity'] . "<br>";
      }
      $headers = implode("\r\n", [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=utf-8',
        'From: john@doe.com'
      ]);
      echo @mail($to, $subject, $message, $headers) ? "OK" : "Ошибка отправки имейла" ;
    }
    else
    {
      echo $cartLib->error;
    }
    break;
  default:
    echo "Неверный запрос, вернитесь на страницу с товарами";
    break;
}
?>