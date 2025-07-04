<?php
/**
 * Created by Netivo for Elazienki Theme v2
 * User: manveru
 * Date: 26.09.2024
 * Time: 12:43
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

$min           = $options['min'];
$min_price     = $options['min_price'];
$min_val       = $options['min_val'];
$min_price_val = $options['min_price_val'];
$max           = $options['max'];
$max_price     = $options['max_price'];
$max_price_val = $options['max_price_val'];
$max_val       = $options['max_val'];


?>
<div class="netivo-filters__section">
    <div class="netivo-filters__section-content" data-element="content">
        <div class="netivo-filters__price">
            <div class="title title--small">
				<?= apply_filters( 'price_filter_title', __( 'Cena', 'netivo' ) ); ?>
            </div>
            <div class="netivo-filters__price-wrapper price_slider_wrapper js-price-slider">
                <div class="price_slider" id="price_slider" style="display:none;"></div>
                <div class="price_slider_amount">
                        <span class="price_slider_span">
                            <label for="min_price"><?php echo __( 'od:', 'netivo' ); ?></label>
                            <input type="text" id="min_price" value="<?= esc_attr( $min_price ); ?>"
                                   data-min="<?= esc_attr( apply_filters( 'woocommerce_price_filter_widget_min_amount', $min ) ); ?>"
                                   placeholder="<?= esc_attr__( 'Min price', 'woocommerce' ); ?>"/>
                            <span>zł</span>
                            <input type="hidden" name="min_price" id="real_min_price"
                                   value="<?= $min_price_val; ?>" <?php echo ( $min_price_val == $min_val ) ? 'disabled' : ''; ?> />
                        </span>
                    <span class="price_slider_span">
                            <label for="max_price"><?php echo __( 'do:', 'netivo' ); ?></label>
                            <input type="text" id="max_price" value="<?= esc_attr( $max_price ); ?>"
                                   data-max="<?= esc_attr( apply_filters( 'woocommerce_price_filter_widget_max_amount', $max ) ); ?>"
                                   placeholder="<?= esc_attr__( 'Max price', 'woocommerce' ); ?>"/>
                            <span>zł</span>
                            <input type="hidden" name="max_price" id="real_max_price"
                                   value="<?= $max_price_val; ?>" <?php echo ( $max_price_val == $max_val ) ? 'disabled' : ''; ?> />
                        </span>
                    <div class="price_label" style="display:none;"><span class="from"></span><span class="to"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>