<?php
if(!defined('ABSPATH')){
	return;
}
?>
<div id="popup-container">
    <div id="popup-content">
        <h2>Product Added to Cart</h2>
        <p>Product name: <?php echo esc_html($product->get_name()); ?></p>
        <button id="popup-close-button">Close</button>
    </div>
</div>
