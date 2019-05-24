/*
  todo
  1. не реализован интерфейс для вывода сообщений обратной связи
  использую обычные алерты
  2. пофиксить поведение кнопки "назад" в браузере
*/
var cart = {
  ajax : function (opt)
  {
    //* вспомогательная функция, выполняет AJAX-запрос
  // PARAM opt.data : data to be sent, an object with key-value pairs
  //       opt.url : target URL
  //       opt.target : (optional) ID of HTML element, put server response in here if provided
  //       opt.load : (optional) function to call when AJAX load is complete

    // DATA
    var data = null;
    if (opt.data) {
      data = new FormData();
      for (var d in opt.data) {
        data.append(d, opt.data[d]);
      }
    }

    // AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', opt.url, true);
    xhr.onload = function(){
      if (xhr.status!=200) {
        console.log(xhr);
        alert("AJAX error. Server responded with error code " + xhr.status + " " + xhr.statusText);
      } else {
        if (opt.target) {
          document.getElementById(opt.target).innerHTML = this.response;
        }
        if (typeof opt.load == "function") {
          opt.load(this.response);
        }
      }
    };
    xhr.send(data);
  },

  add : function (id) {
  // add () : add item to cart
  // PARAM id : product ID

    cart.ajax({
      url : "ajax-cart.php",
      data : {
        req : "add",
        product_id : id
      },
      load : function (res) {
        cart.count();
        // @TODO
        alert(res);
      }
    });
  },

  count : function () {
  // count() : update items count

    cart.ajax({
      url : "ajax-cart.php",
      data : { req : "count", },
      target : "page-cart-count"
    });
  },

  toggle : function (reload) {
  // toggle() : show/hide cart
  // PARAM reload : force cart reload?

    var pgPdt = document.getElementById("page-products"),
        pgCart = document.getElementById("page-cart");

    if (reload || pgCart.classList.contains("ninja")) {
      cart.ajax({
        url : "ajax-cart.php",
        data : { req : "show", },
        target : "page-cart",
        load : function () {
          pgPdt.classList.add("ninja");
          pgCart.classList.remove("ninja");
        }
      });
    } else {
      pgPdt.classList.remove("ninja");
      pgCart.classList.add("ninja");
    }
  },

  change : function (id) {
  // change() : change quantity

    var qty = document.getElementById("qty_"+id).value;
    cart.ajax({
      url : "ajax-cart.php",
      data : {
        req : "change",
        product_id : id,
        qty : qty
      },
      load : function (res) {
        cart.count();
        cart.toggle(1);
        // @TODO
        alert(res);
      }
    });
  },

  remove : function (id) {
  // remove() : remove item from cart

    document.getElementById("qty_"+id).value = 0;
    cart.change(id);
  },

  checkout : function ()
  {
    //* оформление заказа

    cart.ajax({
      url : "ajax-cart.php",
      data : {
        req : "checkout",
        // @TODO
        // Change to checkout-email if you want an email to be sent on checkout
        // req : "checkout-email",
        name : document.getElementById("co_name").value,
        email : document.getElementById("co_email").value
      },
      load : function (res) {
        if (res=="OK") {
          window.location = "thank-you.php";
        } else {
          gen.nShow(res);
        }
      }
    });
    return false;
  }
};

window.addEventListener("load", cart.count);