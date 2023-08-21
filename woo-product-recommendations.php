<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
function wpr_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_style('woopr-bootstrap-style', plugins_url('/assets/public/css/bootstrap.min.css',__FILE__), null, '1.0', 'all');
    wp_enqueue_style('woopr-fontawesome-style', plugins_url('/assets/public/css/fontawesome.min.css',__FILE__), null, '1.0', 'all');
    wp_enqueue_style('woopr-main-style', plugins_url('/assets/public/css/main.css',__FILE__), null, '1.0', 'all');
    // wp_enqueue_style('woopr-carousel-style', plugins_url('/assets/public/css/owl.carousel.min.css',__FILE__), null, '1.0', 'all');
    // wp_enqueue_style('woopr-theme-style', plugins_url('/assets/public/css/owl.theme.default.min.css',__FILE__), null, '1.0', 'all');
    wp_enqueue_style('woopr-responsive-style', plugins_url('/assets/public/css/responsive.css',__FILE__), null, '1.0', 'all');

    wp_enqueue_script('woopr-bootstrap-script', plugins_url('/assets/public/js/bootstrap.bundle.min.js',__FILE__), ['jquery'], '1.0', true);
    wp_enqueue_script('woopr-jquery-script', plugins_url('/assets/public/js/jquery-3.6.1.min.js',__FILE__), ['jquery'], '1.0', true);
    // wp_enqueue_script('woopr-main-script', plugins_url('/assets/public/js/main.js',__FILE__), ['jquery'], '1.0', true);
    // wp_enqueue_script('woopr-carousel-script', plugins_url('/assets/public/js/owl.carousel.min.js',__FILE__), ['jquery'], '1.0', true);
    // For popup and ajax add cart 
    if(is_product()):
        wp_enqueue_style('woopr-popup-style', plugins_url('/assets/public/popup-cont/popup.css',__FILE__), null, '1.0', 'all');
        wp_enqueue_script('woopr-popup-script', plugins_url('/assets/public/popup-cont/popup.js',__FILE__), ['jquery'], '1.0', true);
        // wp_enqueue_script('woopr-add-to-cart-script', plugins_url('/assets/public/popup-cont/add-to-cart.js',__FILE__), ['jquery'], '1.0', true);
        // wp_enqueue_script('woopr-jquery-script', 'https://code.jquery.com/jquery-3.7.0.min.js', ['jquery'], '1.0', true);
    endif;
}
add_action('wp_enqueue_scripts', 'wpr_enqueue_scripts');

/*
// Add popup content to WooCommerce "Add to Cart" button
function custom_popup_on_add_to_cart() {
    global $product;

    // Get the related products
    $related_products = wc_get_related_products($product->get_id());
    $related_18 = 18;

    ?>
    <div id="popup-container">
        <div id="popup-content">
            <span id="popup-close-button">Close</span>
            <?php echo '<a href="' . wc_get_cart_url() . '" class="popup-view-cart-button view-cart-link">View Cart --></a>'; ?>
            <h2>You may choose products</h2>
            <div class="related-products">
                <?php echo $related_18; ?>
                <?php foreach ($related_18 as $related_id) {
                    $related_product = wc_get_product($related_id);
                    ?>
                    <div class="related-product">
                        <a href="<?php echo esc_url(get_permalink($related_id)); ?>"><?php echo esc_html($related_product->get_name()); ?></a>
                        <span class="related-product-price"><?php echo $related_product->get_price_html(); ?></span>
                    </div>
                    <?php
                } ?>
            </div>
        </div>
    </div>
    <?php
}
add_action('woocommerce_after_add_to_cart_button', 'custom_popup_on_add_to_cart');
*/

add_action('woocommerce_after_add_to_cart_button', 'custom_output_related_products');
function custom_output_related_products() {
    global $product;
    echo 'Something here';
    $related_product_ids = wc_get_related_products($product->get_id(), 4, true);
    print_r($related_product_ids);
    
}


// AJAX function to add product to cart
function woocommerce_ajax_add_to_cart() {
    // Ensure the WooCommerce core functions are available
    if (function_exists('WC')) {
        // Get product ID and quantity from the AJAX request
        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Check if the product ID is valid
        if ($product_id > 0) {
            // Add the product to the cart
            WC()->cart->add_to_cart($product_id, $quantity);
        }
    } else {
        // WooCommerce is not active or not properly loaded
        $response = array(
            'success' => false,
            'message' => 'WooCommerce is not active.',
        );
    }

    // Send the JSON response
    wp_send_json($response);
}
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart'); // If you need to handle non-logged in users

// Your existing script
function add_ajax_to_cart_script() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('.single_add_to_cart_button').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var productID = button.val();
                var quantity = 1;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'woocommerce_ajax_add_to_cart',
                        product_id: productID,
                        quantity: quantity,
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.fragments) {
                                $.each(response.fragments, function(key, value) {
                                    $(key).replaceWith(value);
                                });
                            }
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        // Display an error message
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'add_ajax_to_cart_script');



// can you add here?