<?php
/**
 * Created by Netivo for Netivo Modules
 * User: manveru
 * Date: 14.05.2026
 * Time: 16:19
 *
 */

namespace Netivo\Module\WooCommerce\Filters;

if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class Archive {

	public function __construct() {

		add_filter( 'posts_clauses', [ $this, 'availability_filter' ], 10, 2 );
	}

	public function availability_filter( $args, $query ) {
		if ( $query->is_main_query() && ! empty( $_GET['filter_availability'] ) ) {
			$filter = explode( ',', wc_clean( wp_unslash( $_GET['filter_availability'] ) ) );
			if ( ! empty( $filter ) ) {
				if ( ! in_array( 'order', $filter ) ) {
					global $wpdb;
					$args['join'] = $args['join'] . " LEFT JOIN {$wpdb->prefix}wc_product_meta_lookup nt_lookup ON {$wpdb->posts}.ID = nt_lookup.product_id";
					if ( in_array( 'yes', $filter ) && count( $filter ) == 1 ) {
						$args['where'] = $args['where'] . ' AND nt_lookup.stock_status = \'instock\'';
					} elseif ( in_array( 'no', $filter ) && count( $filter ) == 1 ) {
						$args['where'] = $args['where'] . ' AND nt_lookup.stock_status = \'outofstock\'';
					}
				}
			}
			apply_filters( 'netivo/widget/filters/availability-clauses', $args, $filter, $query );
		}

		return $args;
	}
}