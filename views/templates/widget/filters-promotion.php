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
            <div class="netivo-filters__attribute js-hidden-filter-options">
                <div class="title title--small" id="filer-promotion">
                    <?= apply_filters('promotion_filter_title', __('Promocja', 'netivo')); ?>
                </div>
                <div class="netivo-filters__attribute-container js-attribute-filter" aria-labelledby="filer-promotion" role="menu">
                    <input type="hidden" name="filter_promotion" data-element="filter"
                           value="<?= implode( ',', $active_filters ); ?>"/>
                    <?php foreach($filters as $filter): ?>
                        <div class="netivo-filters__term" role="none">
                            <input type="checkbox" value="<?= $filter['id']; ?>" role="menuitemcheckbox" aria-labelledby="t-<?= $filter['id']; ?>"
                                   data-link="<?php echo $filter['link']; ?>" id="t-<?= $filter['id']; ?>"
                                   data-element="checkbox"
                                   class="form__checkbox" <?= ( $filter['active'] ) ? 'checked' : ''; ?>/>
                            <label class="netivo-filters__term-name" for="t-<?= $filter['id']; ?>">
                                <?= $filter['name']; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
