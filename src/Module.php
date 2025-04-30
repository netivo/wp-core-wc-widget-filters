<?php
/**
 * Created by Netivo for modules
 * User: manveru
 * Date: 30.04.2025
 * Time: 13:43
 *
 */

namespace Netivo\Module\WooCommerce\Filters;

use Netivo\Module\WooCommerce\Filters\Admin\Page\Filters;
use Netivo\Module\WooCommerce\Filters\Widget\Filters as WidgetFilters;

if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class Module {
	public function __construct() {
		if ( is_admin() ) {
			$path = realpath( __DIR__ . '/../views' );
			new Filters( $path, [] );
		}
		add_action( 'widgets_init', [ $this, 'init_widget' ] );
	}

	public function init_widget(): void {
		register_widget( WidgetFilters::class );
	}
}