<?php
/**
 * Plugin Name: AAWoo Product Recommendations
 * Description: Woo Product Recommendations plugin is a product single page that enables customers to have a quick look at a product without visiting the product page.
 * Plugin URI: https://bestwpdeveloper.com/shop/
 * Version: 1.0
 * Author: Best WP Developer
 * Author URI: https://bestwpdeveloper.com/
 * Text Domain: woo-product-recommendations
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
function wpr_enqueue_scripts() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'wpr_enqueue_scripts');

// Add footer script for the popup functionality
function wpr_footer_script() {
    global $product;

    // Get the related product IDs
    $related_product_ids = get_post_meta($product->get_id(), 'related_products', true);
    
    // Convert the related product IDs to an array
    $related_product_ids_array = explode(',', $related_product_ids);

    // Output the related product IDs as a JavaScript array
    echo '<script>';
    echo 'var relatedProductIDs = ' . json_encode($related_product_ids_array) . ';';
    echo '</script>';
    ?>
    <style>
        #popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        #popup-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            top: 100px;
        }

        #popup-close-button {
            background-color: #f44336;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        #popup-close-button:hover {
            background-color: #d32f2f;
        }

        .related-product {
            margin: 10px 0;
        }
    </style>
    <script>
        jQuery(document).ready(function($) {
            // Open the popup when the "Add to Cart" button is clicked
            $('.single_add_to_cart_button').on('click', function(e) {
                e.preventDefault();

                var productID = $(this).data('product_id');
                var productName = $(this).data('product-name');
                $('#product-name').text(productName);

                // Create a container for related products
                var relatedProductsHTML = '<div id="related-products">';

                // Loop through related product IDs and generate HTML
                relatedProductIDs.forEach(function(relatedID) {
                    // Simulated related product name (replace with your actual data)
                    var relatedProductName = 'Related Product ' + relatedID;
                    
                    // Simulated related product URL (replace with your actual data)
                    var relatedProductURL = 'https://example.com/product/' + relatedID;

                    // Add related product HTML
                    relatedProductsHTML += '<div class="related-product">';
                    relatedProductsHTML += '<a href="' + relatedProductURL + '">' + relatedProductName + '</a>';
                    relatedProductsHTML += '</div>';
                });

                // Close the related products container
                relatedProductsHTML += '</div>';

                // Set the related products content
                $('#related-products').html(relatedProductsHTML);

                $('#popup-container').fadeIn();
                console.log(productID);
            });

            // Close the popup when the close button is clicked
            $('#popup-close-button').on('click', function() {
                $('#popup-container').fadeOut();
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'wpr_footer_script');
?>