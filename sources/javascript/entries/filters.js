import HiddenFilters from "./../hiddenFilters";
import AttributeFilter from "./../attributeFilter";
import LinkFilter from "./../linkFilter";

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
