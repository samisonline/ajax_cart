
<?php 
//to be inserted into functions.php, not instead of!


//makes cart count updates when products are added to the cart via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment', 'woocommerce_header_add_to_mini_cart_fragment' );
    function woocommerce_header_add_to_cart_fragment( $fragments ) {ob_start();?>
        <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></a>
    <?php   
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}
//makes mini-cart contents update when products are added to the cart via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_mini_cart_fragment' );

    function woocommerce_header_add_to_mini_cart_fragment( $mini_cart ) {ob_start();?>
    <div class="mini-cart-inner">
        <?php
        global $woocommerce;
            $items = $woocommerce->cart->get_cart();
            $currency = get_woocommerce_currency_symbol();

            if (!$items) {
                echo '<span class="no-items-mini">No items added</span>';
            }

                foreach($items as $item => $values) { 
                    $_product = $values['data']->post; 
                    $link = get_permalink($_product);
                    echo "<span>";
                        echo $values['quantity']." x <a href='".$link."'>".$_product->post_title;
                    echo "<a/></span>";
                    $price = get_post_meta($values['product_id'] , '_price', true);
                    echo "  Price: ".$currency.$price."<br>";
                }
            $total = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
            echo "<span class='mini-total'><b>Total: </b>".$currency.$total."</span>";
        ?>
    </div>

    <?php   
    $mini_cart['.mini-cart-inner'] = ob_get_clean();
    return $mini_cart;
}
?>