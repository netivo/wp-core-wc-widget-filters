<?php
/**
 * Display the filters for attributes
 *
 * @var $filters array Array of the possible filters
 */

defined( 'ABSPATH' ) || exit;

$options_active = [];

foreach ( $filters['filters'] as $filter ) {
	if ( $filter['active'] ) {
		$options_active[] = $filter['id'];
	}
}

?>

<?php if ( ! empty( $filters['filter_option_count'] ) ) : ?>
    <div class="netivo-filters__section">
        <div class="netivo-filters__section-content" data-element="content">
            <div class="netivo-filters__attributes">
                <div class="netivo-filters__attribute js-hidden-filter-options">

                    <div class="title title--small">
						<?= apply_filters( 'availability_filter_title', __( 'Dostępność', 'netivo' ) ); ?>
                    </div>
                    <div class="netivo-filters__attribute-container js-attribute-filter">
                        <input type="hidden" name="filter_availability" data-element="filter"
                               value="<?= implode( ',', $options_active ); ?>"/>
						<?php foreach ( $filters['filters'] as $filter ): ?>
                            <div class="netivo-filters__term"
                                 style="<?= ( ! $filter['is_set'] ) ? 'display: none;' : ''; ?>" <?= ( ! $filter['is_set'] ) ? 'data-element="hidden-options-container"' : ''; ?>>
                                <input type="checkbox" value="<?= $filter['id']; ?>"
                                       data-link="<?php echo $filter['link']; ?>" id="t-<?= $filter['id']; ?>"
                                       data-element="checkbox"
                                       class="form__checkbox" <?= ( $filter['active'] ) ? 'checked' : ''; ?>/>
                                <label class="netivo-filters__term-name" for="t-<?= $filter['id']; ?>">
									<?= $filter['name']; ?>
                                    <span class="netivo-filters__term-count">(<?php echo $filter['count']; ?>)</span>
                                </label>
                            </div>
						<?php endforeach; ?>
						<?php if ( $filters['count_show'] < $filters['filter_option_count'] ): ?>
                            <a href="" class="netivo-filters__attributes-show-more"
                               data-element="hidden-options-button"
                               data-show-more-text="<?php echo __( 'Pokaż więcej', 'elazienki' ); ?>"
                               data-show-less-text="<?php echo __( 'Ukryj', 'elazienki' ); ?>"><?php echo __( 'Pokaż więcej', 'elazienki' ); ?></a>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>