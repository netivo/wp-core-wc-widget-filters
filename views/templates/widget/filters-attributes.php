<?php
/**
 * Display the filters for attributes
 *
 * @var $filters array Array of the possible filters
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="netivo-filters__section">
    <div class="netivo-filters__section-content" data-element="content">
        <div class="netivo-filters__attributes">
			<?php foreach ( $filters as $filter ) : ?>
                    <div class="netivo-filters__attribute js-hidden-filter-options">
                        <div class="title title--small">
							<?= $filter['filter_name'] ?>
                        </div>
                        <div class="netivo-filters__attribute-container js-attribute-filter">
                            <input type="hidden" name="<?= $filter['input_name']; ?>" data-element="filter"
                                   value="<?= implode( ',', array_map( function ( $e ) {
								       return $e['slug'];
							       }, $filter['options_active'] ) ); ?>"/>
                            <input type="hidden"
                                   name="<?= 'query_type_' . sanitize_title( str_replace( 'pa_', '', $filter['taxonomy'] ) ); ?>"
                                   value="or"/>
							<?php $current_options_count = 0; ?>
							<?php foreach ( $filter['options_all'] as $term ): ?>
                                <div class="netivo-filters__term"
                                     style="<?= ( ! $term['active'] ) ? 'display: none;' : ''; ?>" <?= ( ! $term['active'] ) ? 'data-element="hidden-options-container"' : ''; ?>>
                                    <input type="checkbox" value="<?= $term['slug']; ?>"
                                           data-link="<?php echo $term['link']; ?>" id="t-<?= $term['id']; ?>"
                                           data-element="checkbox"
                                           class="form__checkbox" <?= ( $term['is_set'] ) ? 'checked' : ''; ?>/>
                                    <label class="netivo-filters__term-name" for="t-<?= $term['id']; ?>">
										<?= $term['name']; ?> (<?php echo $term['count']; ?>)
                                    </label>
                                </div>
								<?php if ( ! $term['is_set'] ) {
									$current_options_count ++;
								} ?>
							<?php endforeach; ?>
							<?php if ( $filter['count_show'] < $filter['filter_option_count'] ): ?>
                                <a href="" class="netivo-filters__attributes-show-more"
                                   data-element="hidden-options-button"
                                   data-show-more-text="<?php echo __( 'Pokaż więcej', 'netivo' ); ?>"
                                   data-show-less-text="<?php echo __( 'Ukryj', 'netivo' ); ?>"><?php echo __( 'Pokaż więcej', 'netivo' ); ?></a>
							<?php endif; ?>
                        </div>
                    </div>
			<?php endforeach; ?>
        </div>
    </div>
</div>
