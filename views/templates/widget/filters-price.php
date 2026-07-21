<?php
/**
 * Price filter widget template.
 *
 * Renders a noUiSlider dual-handle range slider (vanilla JS, no jQuery).
 *
 * Available variables: $options (min, max, min_price, max_price,
 *                      min_price_val, max_price_val, min_val, max_val)
 */

if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

$min           = $options['min'];
$min_price     = $options['min_price'];
$min_price_val = $options['min_price_val'];
$min_val       = $options['min_val'];
$max           = $options['max'];
$max_price     = $options['max_price'];
$max_price_val = $options['max_price_val'];
$max_val       = $options['max_val'];
?>
<div class="netivo-filters__section">
	<div class="netivo-filters__section-content" data-element="content">
		<div class="netivo-filters__price">
			<div class="title title--small">
				<?php echo wp_kses_post( apply_filters( 'price_filter_title', __( 'Cena', 'netivo' ) ) ); ?>
			</div>
			<div class="netivo-filters__price-wrapper js-price-slider"
			     data-min="<?php echo esc_attr( $min_val ); ?>"
			     data-max="<?php echo esc_attr( $max_val ); ?>"
			     data-min-val="<?php echo esc_attr( $min_price_val ); ?>"
			     data-max-val="<?php echo esc_attr( $max_price_val ); ?>"
			>
				<div class="netivo-filters__price-slider">
					<div class="js-price-range-slider"></div>
				</div>
				<div class="netivo-filters__price-values">
					<span class="netivo-filters__price-label">
						<?php echo esc_html__( 'od:', 'netivo' ); ?>
						<span class="js-price-min"><?php echo esc_html( $min_price_val ); ?></span>&nbsp;zł
					</span>
					<span class="netivo-filters__price-sep">—</span>
					<span class="netivo-filters__price-label">
						<?php echo esc_html__( 'do:', 'netivo' ); ?>
						<span class="js-price-max"><?php echo esc_html( $max_price_val ); ?></span>&nbsp;zł
					</span>
				</div>
				<input type="hidden" name="min_price" value="<?php echo esc_attr( $min_price_val ); ?>"
				       <?php echo ( $min_price_val == $min_val ) ? 'disabled' : ''; ?> />
				<input type="hidden" name="max_price" value="<?php echo esc_attr( $max_price_val ); ?>"
				       <?php echo ( $max_price_val == $max_val ) ? 'disabled' : ''; ?> />
			</div>
		</div>
	</div>
</div>