jQuery(document).ready(function($) {
  // Open the popup when the "Add to Cart" button is clicked
  $('.single_add_to_cart_button').on('click', function(e) {
      e.preventDefault();

      var productID = $(this).data('product_id');
      var productName = $(this).data('product-name');
      $('#product-name').text(productName);
      $('#popup-container').fadeIn();

      // Add the product to the cart using AJAX
      $.ajax({
          type: 'POST',
          url: wc_add_to_cart_params.ajax_url,
          data: {
              action: 'woocommerce_add_to_cart',
              product_id: productID,
          },
          success: function(response) {
              // Update cart total in the header (optional)
              if (response.fragments) {
                  $.each(response.fragments, function(key, value) {
                      $(key).replaceWith(value);
                  });
              }
          }
      });
  });

  // Close the popup when the close button is clicked
  $('#popup-close-button').on('click', function() {
      $('#popup-container').fadeOut();
  });
});