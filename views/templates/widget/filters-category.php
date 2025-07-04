<?php
/**
 * Display the filters for categories
 *
 * @var $parent int Category parent ID
 * @var $categories array Array of the categories
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="netivo-filters__section">
    <div class="title title--small" id="filter_categories">
		<?= apply_filters( 'netivo_filters_category_title', __( 'Kategorie:', 'netivo' ) ); ?>
    </div>
    <div class="netivo-filters__section-content">
		<?php if ( !empty($parent) ) : ?>
            <div class="netivo-filters__back">
                <span><?= __( 'cofnij do', 'netivo' ) ?></span> <a
                        href="<?= $parent['link']; ?>"><?php echo $parent['name']; ?></a>
            </div>
		<?php endif; ?>
        <ul class="netivo-filters__categories js-filter-categories" aria-labelledby="filter_categories" role="menu">
			<?php foreach ( $categories as $category ) : ?>
				<?php
				$classes      = [ 'netivo-filters__category' ];
				$is_active    = false;
				$has_children = false;
				if ( ! empty( $category['subcategories'] ) ) {
					$classes[]    = 'has-submenu';
					$has_children = true;
				}
				if ( $category['active'] ) {
					$classes[] = 'active';
					$classes[] = 'open';
					$is_active = true;
				}
				?>
                <li class="<?= implode( ' ', $classes ); ?>" role="none" data-open="<?= $is_active ? 1 : 0; ?>">
                    <a href="<?= $category['link']; ?>" <?php echo ($is_active) ? 'aria-current="page"' : ''; ?>  class="netivo-filters__category-title" role="menuitem" data-element="title">
						<?= $category['name']; ?><span
                                class="netivo-filters__category-count" aria-label="<?php echo esc_attr(sprintf(__('%s produktów', 'netivo'), $category['count'])); ?>">(<?= $category['count']; ?>)</span>
                    </a>
					<?php if ( $has_children ) : ?>
                        <ul class="netivo-filters--subcategories" role="menu" data-element="content" aria-label="<?php echo esc_attr(sprintf(__('Podkategorie %s', 'netivo'), $category['name'])); ?>">
							<?php foreach ( $category['subcategories'] as $subcategory ) : ?>
                                <li class="netivo-filters__category" role="none">
                                    <a href="<?= $subcategory['link']; ?>" role="menuitem" class="netivo-filters__category-title">
										<?= $subcategory['name']; ?><span
                                                class="netivo-filters__category-count" aria-label="<?php echo esc_attr(sprintf(__('%s produktów', 'netivo'), $subcategory['count'])); ?>">(<?= $subcategory['count']; ?>)</span>
                                    </a>
                                </li>
							<?php endforeach; ?>
                        </ul>
					<?php endif; ?>
                </li>
			<?php endforeach; ?>
        </ul>
    </div>
</div>
