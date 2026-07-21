import noUiSlider from 'nouislider';

class PriceFilter {
  constructor(wrapper) {
    this.wrapper = wrapper;
    this.sliderEl = wrapper.querySelector('.js-price-range-slider');
    this.minInput = wrapper.querySelector('input[name="min_price"]');
    this.maxInput = wrapper.querySelector('input[name="max_price"]');
    this.minDisplay = wrapper.querySelector('.js-price-min');
    this.maxDisplay = wrapper.querySelector('.js-price-max');

    if (!this.sliderEl || !this.minInput || !this.maxInput) {
      return;
    }

    this.min = parseFloat(wrapper.dataset.min);
    this.max = parseFloat(wrapper.dataset.max);
    this.minVal = parseFloat(wrapper.dataset.minVal);
    this.maxVal = parseFloat(wrapper.dataset.maxVal);

    this._init();
  }

  _init() {
    this.slider = noUiSlider.create(this.sliderEl, {
      start: [this.minVal, this.maxVal],
      connect: true,
      range: { min: this.min, max: this.max },
      step: 1,
      format: {
        to: (v) => Math.round(v),
        from: (v) => parseFloat(v),
      },
    });

    this.slider.on('update', ([minPrice, maxPrice]) => {
      if (this.minDisplay) {
        this.minDisplay.textContent = minPrice;
      }
      if (this.maxDisplay) {
        this.maxDisplay.textContent = maxPrice;
      }
      this.minInput.value = minPrice;
      this.maxInput.value = maxPrice;
      // Disable inputs at defaults so they don't appear as URL params.
      this.minInput.disabled = parseInt(minPrice, 10) === this.min;
      this.maxInput.disabled = parseInt(maxPrice, 10) === this.max;
    });

    this.slider.on('change', ([minPrice, maxPrice]) => {
      // In non-form mode navigate directly; form mode uses submit button.
      const form = this.wrapper.closest('form');
      if (!form) {
        const url = new URL(window.location.href);
        if (parseInt(minPrice, 10) === this.min) {
          url.searchParams.delete('min_price');
        } else {
          url.searchParams.set('min_price', minPrice);
        }
        if (parseInt(maxPrice, 10) === this.max) {
          url.searchParams.delete('max_price');
        } else {
          url.searchParams.set('max_price', maxPrice);
        }
        // Remove pagination when changing filter
        url.searchParams.delete('paged');
        window.location.href = url.toString();
      }
    });
  }
}

export default PriceFilter;
