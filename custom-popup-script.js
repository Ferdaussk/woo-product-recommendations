jQuery(document).ready(function($) {
  // Open the popup when the "Add to Cart" button is clicked
  $('.single_add_to_cart_button').on('click', function() {
      var productName = $(this).data('product-name'); // Get the product name from a data attribute
      $('#product-name').text(productName); // Set the product name in the popup
      $('#popup-container').fadeIn();
  });

  // Close the popup when the close button is clicked
  $('#popup-close-button').on('click', function() {
      $('#popup-container').fadeOut();
  });
});
