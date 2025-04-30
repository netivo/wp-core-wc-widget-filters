<?php

namespace Netivo\Module\WooCommerce\Filters\Admin\Page;

use Netivo\Core\Admin\Page;

#[\Netivo\Attributes\View( 'filters' )]
class Filters extends Page {
	/**
	 * Name of the page used as view name
	 *
	 * @var string
	 */
	protected string $_name = 'filters';

	/**
	 * Page type. One of: main, subpage, tab
	 * main - Main page will display in first level menu
	 * subpage - Sub page will display in second level menu, MUST have parent attribute
	 * tab - Tab for page, will not display in menu, MUST have parent attribute
	 *
	 * @var string
	 */
	protected string $_type = 'subpage';

	/**
	 * The text to be displayed in the title tags of the page when the menu is selected.
	 *
	 * @var string
	 */
	protected string $_page_title = 'Ustawienia filtrów';

	/**
	 * The text to be used for the menu.
	 *
	 * @var string
	 */
	protected string $_menu_text = 'Ustawienia filtrów';
	/**
	 * The capability required for this menu to be displayed to the user.
	 *
	 * @var string
	 */
	protected string $_capability = 'manage_options';
	/**
	 * The slug name to refer to this menu by. Should be unique for this menu page and only include lowercase alphanumeric, dashes, and underscores characters to be compatible with sanitize_key()
	 *
	 * @var string
	 */
	protected string $_menu_slug = 'nt_filters';

	/**
	 * The slug name for the parent element (or the file name of a standard WordPress admin page).
	 * Needed when submenu or tab
	 *
	 * @var string
	 */
	protected string $_parent = 'edit.php?post_type=product';


	/**
	 * Action done before displaying content
	 */
	public function do_action(): void {
		$this->view->filters = get_option( '_nt_filters', [] );
	}

	/**
	 * Save function, to be used in child class.
	 * Main data saving is done here.
	 */
	public function save(): void {
		$filters = get_option( '_nt_filters', [] );
		if ( ! empty( $_POST['filters'] ) ) {
			$nfilters = $_POST['filters'];
			if ( ! empty( $_GET['nt_cat'] ) ) {
				$filters[ $_GET['nt_cat'] ] = $nfilters[ $_GET['nt_cat'] ];
				update_option( '_nt_filters', $filters );
			}
		} else {
			if ( ! empty( $_GET['nt_cat'] ) ) {
				$filters[ $_GET['nt_cat'] ] = [];
				update_option( '_nt_filters', $filters );
			}
		}
	}
}