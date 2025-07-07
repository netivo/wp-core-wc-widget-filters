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
                    <?= apply_filters( 'promotion_filter_title', __( 'Promocja', 'netivo' ) ); ?>
                </div>
                <div class="netivo-filters__attribute-container <?php echo ( $form ) ? 'js-attribute-filter' : 'js-link-filter'; ?>"
                     tabindex="0"
                     aria-labelledby="filer-promotion" role="menu">
                    <?php if ( $form ) : ?>
                        <input type="hidden" name="filter_promotion" data-element="filter"
                               value="<?= implode( ',', $active_filters ); ?>"/>
                    <?php endif; ?>
                    <?php foreach ( $filters as $filter ): ?>
                        <div class="netivo-filters__term" role="none">
                            <input type="checkbox" value="<?= $filter['id']; ?>" role="menuitemcheckbox"
                                   aria-labelledby="tl-<?= $filter['id']; ?>"
                                   data-link="<?php echo $filter['link']; ?>" id="t-<?= $filter['id']; ?>"
                                   data-element="checkbox"
                                   class="form__checkbox" <?= ( $filter['active'] ) ? 'checked' : ''; ?>/>
                            <label class="netivo-filters__term-name" for="t-<?= $filter['id']; ?>"
                                   id="tl-<?= $filter['id']; ?>">
                                <?= $filter['name']; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>

                    <?php if ( $form ) : ?>
                        <a href="" style="text-indent: -999999px" role="button" class="js-filters-go-to-submit">
                            <?php echo __( 'Przejdź do zatwierdzenia filtrów', 'netivo' ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
