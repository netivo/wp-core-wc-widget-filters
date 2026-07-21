import HiddenFilters from "./../hiddenFilters";
import AttributeFilter from "./../attributeFilter";
import LinkFilter from "./../linkFilter";
import PriceFilter from "./../priceFilter";

document.addEventListener("DOMContentLoaded", () => {
  let data_filters_hidden = document.querySelectorAll(
    ".js-hidden-filter-options",
  );
  if (data_filters_hidden.length > 0) {
    data_filters_hidden.forEach((filter) => {
      new HiddenFilters(filter);
    });
  }
  let attribute_filter = document.querySelectorAll('.js-attribute-filter');
  if (attribute_filter.length > 0) {
    attribute_filter.forEach(filter => {
      new AttributeFilter(filter);
    });
  }
  let link_filter = document.querySelectorAll('.js-link-filter');
  if (link_filter.length > 0) {
    link_filter.forEach(filter => {
      new LinkFilter(filter);
    });
  }
  let price_sliders = document.querySelectorAll('.js-price-slider');
  if (price_sliders.length > 0) {
    price_sliders.forEach(wrapper => {
      new PriceFilter(wrapper);
    });
  }

  let filter_go_submit = document.querySelectorAll('.js-filters-go-to-submit');
  if (filter_go_submit.length > 0) {
    filter_go_submit.forEach(filter => {
      filter.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelector('.js-filters-submit').focus();
      });
    });
  }

});
