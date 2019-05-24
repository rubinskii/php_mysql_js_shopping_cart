<?php
class Products extends Database {
  function get()
  {
  // получаю все товары
    return $this->fetch(
      "
        SELECT * 
        FROM `products`
      ",
      null,
      "product_id"
    );
  }
// ! нет реализации
// todo функционал добавления, редактирования и удаления товаров в БД
/*
  function add($name, $img, $desc, $price)
  {
    // todo добавить новый товар
    return $this->exec(
      "
        INSERT INTO `products`
        (`product_name`, `product_image`, `product_description`, `product_price`)VALUES (?, ?, ?, ?)
      ",
      [$name, $img, $desc, $price]
    );
  }

  function edit($id, $name, $img, $desc, $price)
  {
    // todo редактировать товар
    return $this->exec(
      "
        UPDATE `products`
        SET `product_name`=?, `product_image`=?, `product_desc`=?, `product_price`=? WHERE `product_id`=?
      ",
      [$name, $img, $desc, $price, $id]
    );
  }

  function del ($id)
  {
    // todo удалить товар

    return $this->exec(
      "
        DELETE FROM `products`
        WHERE `product_id`=?
      ",
      [$id]
    );
  }
  */
}
?>
