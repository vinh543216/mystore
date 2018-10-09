+function ($) {
  'use strict';
  let urlUpdate = '/shop-new/cart/update/';
  let urlDelete = '/shop-new/cart/delete/';
  let urlCallback = window.location.pathname;
  function updateCart() {
    $('.updateCart').click(function () {
      var rowid = $(this).attr('id');
      console.log(rowid);
      var qty = $(this).parent().parent().find('.qty').val();
      console.log(qty);
      // var token = $("input[name='_token']").val();
      $.ajax({
        url: urlUpdate + rowid + '/' + qty,
        type: 'post',
        cache: false,
        dataType: 'json',
        data: {"id": rowid, 'quality': qty},
        success: function (data) {
          if (data.message) {
            window.location =urlCallback;
          }
        }
      });
    });
  }

  function deleteCart() {
    $('.deleteCart').click(function () {
      var rowid = $(this).attr('id');
      console.log(rowid);
      var qty = $(this).parent().parent().find('.qty').val();
      console.log(qty);
      // var token = $("input[name='_token']").val();
      $.ajax({
        url: urlDelete + rowid,
        type: 'post',
        cache: false,
        dataType: 'json',
        data: {"id": rowid},
        success: function (data) {
          if (data.message) {
            window.location =urlCallback;
          }
        }
      });
    });
  }

  $(document).ready(function () {
    updateCart();
    deleteCart();
  });
}(jQuery);
