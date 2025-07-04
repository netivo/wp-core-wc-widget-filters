import HiddenFilters from "./../hiddenFilters";

document.addEventListener('DOMContentLoaded', () => {
  let data_filters_hidden = document.querySelectorAll('.js-hidden-filter-options');
  if (data_filters_hidden.length > 0) {
    data_filters_hidden.forEach(filter => {
      new HiddenFilters(filter);
    });
  }
});