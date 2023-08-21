<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
function wpr_enqueue_scripts() {
    wp_enqueue_style('make-a-data-style', 'fff', ['jquery'], '1.0', 'all');
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'wpr_enqueue_scripts');

// Add popup content to WooCommerce "Add to Cart" button
function custom_popup_on_add_to_cart() {
    global $product;
        ?>
        <div id="popup-container">
            <div id="popup-content">
                <h2>Product Added to Cart</h2>
                <button id="popup-close-button">Close</button>
            </div>
        </div>
        <?php
}
add_action('woocommerce_after_add_to_cart_button', 'custom_popup_on_add_to_cart');

add_action('wp_footer', 'add_ajax_to_single_add_to_cart_button');
function add_ajax_to_single_add_to_cart_button() {
    // Check if we are on a single product page
    if (is_product()) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Listen for "Add to Cart" button click
            $('.single_add_to_cart_button').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                var button = $(this);
                var productID = button.val(); // Get the product ID
                var quantity = 1; // Set the quantity to 1 for simplicity

                // Send AJAX request to add the product to the cart
                $.ajax({
                    type: 'POST',
                    url: wc_add_to_cart_params.ajax_url,
                    data: {
                        action: 'woocommerce_ajax_add_to_cart', // WooCommerce AJAX action
                        product_id: productID,
                        quantity: quantity,
                    },
                    success: function(response) {
                        if (response) {
                            // Update mini-cart fragments
                            if (response.fragments) {
                                $.each(response.fragments, function(key, value) {
                                    $(key).replaceWith(value);
                                });
                            }
                        }
                    },
                });
            });
        });
        </script>
        <?php
    }
}


// after update woocommerce the single page add to button not working