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
	protected string $_view_path = '';

	public function __construct() {
		$this->_view_path = realpath( __DIR__ . '/../views' );
		if ( is_admin() ) {
			new Filters( $this->_view_path, [] );
		}
		add_filter( 'wc_get_template', [ $this, 'change_template_path' ], 10, 5 );
		add_action( 'wp_enqueue_scripts', [ $this, 'add_assets_to_page' ] );
		add_action( 'widgets_init', [ $this, 'init_widget' ] );
	}

	public function change_template_path( $template, $template_name, $args, $template_path, $default_path ): string {
		if ( in_array( $template_name, [
			'widget/filters-category.php',
			'widget/filters-attributes.php',
			'widget/filters-availability.php',
			'widget/filters-promotion.php',
			'widget/filters-price.php'
		] ) ) {
			if ( ! file_exists( $template ) ) {
				$template = $this->_view_path . '/templates/' . $template_name;
			}
		}

		return $template;
	}

	public function add_assets_to_page(): void {
		$path = realpath( __DIR__ . '/../dist' );

		$this->enqueue_style_or_script( $path . '/netivo-woocommerce-filters.css', 'netivo-woocommerce-filters' );
		$this->enqueue_style_or_script( $path . '/netivo-woocommerce-filters.js', 'netivo-woocommerce-filters', 'script' );
	}

	protected function enqueue_style_or_script( $file, $handle, $type = 'style' ): void {
		$td    = get_template_directory();
		$turl  = get_template_directory_uri();
		$nfile = str_replace( $td, $turl, $file );
		if ( $type === 'style' ) {
			wp_enqueue_style( $handle, $nfile, array(), false, 'all' );
		} elseif ( $type === 'script' ) {
			wp_enqueue_script( $handle, $nfile, array(), false, array(
				'in_footer' => true,
				'defer'     => true
			) );
		}
	}

	public function init_widget(): void {
		register_widget( WidgetFilters::class );
	}
}