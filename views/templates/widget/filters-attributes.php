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
                    <div class="title title--small" id="fi-<?php echo $filter['taxonomy']; ?>">
                        <?= $filter['filter_name'] ?>
                    </div>
                    <div class="netivo-filters__attribute-container <?php echo ( $form ) ? 'js-attribute-filter' : 'js-link-filter'; ?>"
                         tabindex="0" role="menu"
                         aria-labelledby="fi-<?php echo $filter['taxonomy']; ?>">
                        <input type="hidden" name="<?= $filter['input_name']; ?>" data-element="filter"
                               value="<?= implode( ',', array_map( function ( $e ) {
                                   return $e['slug'];
                               }, $filter['options_active'] ) ); ?>"/>
                        <input type="hidden"
                               name="<?= 'query_type_' . sanitize_title( str_replace( 'pa_', '', $filter['taxonomy'] ) ); ?>"
                               value="or"/>
                        <?php $current_options_count = 0; ?>
                        <?php foreach ( $filter['options_all'] as $term ): ?>
                            <div class="netivo-filters__term" role="none"
                                 style="<?= ( ! $term['active'] ) ? 'display: none;' : ''; ?>" <?= ( ! $term['active'] ) ? 'data-element="hidden-options-container"' : ''; ?>>
                                <input type="checkbox" value="<?= $term['slug']; ?>" role="menuitemcheckbox"
                                       aria-labelledby="tl-<?= $term['id']; ?>"
                                       data-link="<?php echo $term['link']; ?>" id="t-<?= $term['id']; ?>"
                                       data-element="checkbox"
                                       class="form__checkbox" <?= ( $term['is_set'] ) ? 'checked' : ''; ?>/>
                                <label class="netivo-filters__term-name" for="t-<?= $term['id']; ?>"
                                       id="tl-<?= $term['id']; ?>">
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
                               aria-live="polite"
                               aria-label="<?php echo __( 'Pokaż wszystkie opcje', 'netivo' ); ?>" role="button"
                               data-show-more-text="<?php echo __( 'Pokaż więcej', 'netivo' ); ?>"
                               data-show-less-text="<?php echo __( 'Ukryj', 'netivo' ); ?>"
                               data-show-more-aria="<?php echo __( 'Pokaż wszystkie opcje', 'netivo' ); ?>"
                               data-show-less-aria="<?php echo __( 'Ukryj opcje', 'netivo' ); ?>"><?php echo __( 'Pokaż więcej', 'netivo' ); ?></a>
                        <?php endif; ?>

                        <?php if ( $form ) : ?>
                            <a href="" style="text-indent: -999999px" role="button" class="js-filters-go-to-submit">
                                <?php echo __( 'Przejdź do zatwierdzenia filtrów', 'netivo' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
