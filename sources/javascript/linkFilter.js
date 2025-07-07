class LinkFilter {
  constructor(selector) {
    this.selector = selector;
    this.checkboxes = this.selector.querySelectorAll('[data-element="checkbox"]');

    if (this.checkboxes !== null) {
      this.checkboxes.forEach(checkbox => {
        this._checkboxEvent = this._checkboxEvent.bind(this);
        checkbox.addEventListener('change', this._checkboxEvent);
        checkbox.addEventListener('click', this._checkboxEvent);
      });
    }
  }

  _checkboxEvent(e) {
    e.preventDefault();
    window.location.href = e.target.getAttribute('data-link');
  }
}

export default LinkFilter;