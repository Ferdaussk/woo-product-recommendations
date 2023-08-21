jQuery(document).ready(function($) {
    $('.single_add_to_cart_button').on('click', function(e) {
        e.preventDefault();
        var button = $(this);
        var productID = button.val();
        var quantity = 1;
        $.ajax({
            type: 'POST',
            // url: admin_url('admin-ajax.php'),
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: productID,
                quantity: quantity,
            },
            success: function(response) {
                // alert('Ferdaus sk from ajax l');
                if (response.success) {
                    
                    if (response.fragments) {
                        $.each(response.fragments, function(key, value) {
                            $(key).replaceWith(value);
                        });
                    }
                    
                    alert('Product added to cart!');
                } else {
                    alert('Error adding product to cart.');
                }
            },
            error: function() {
                // Display an error message
                alert('An error occurred. Please try again.');
            }
        });
    });
});