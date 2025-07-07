class HiddenFilters {
  constructor(selector) {
    this.selector = selector;

    this.button = this.selector.querySelector(
      '[data-element="hidden-options-button"]',
    );
    this.container = this.selector.querySelectorAll(
      '[data-element="hidden-options-container"]',
    );

    this._onClickButton = this._onClickButton.bind(this);

    if (this.button !== null) {
      this.button.addEventListener("click", this._onClickButton);

      this.showMoreText = this.button.getAttribute("data-show-more-text");
      this.showLessText = this.button.getAttribute("data-show-less-text");
      this.showMoreAria = this.button.getAttribute("data-show-more-aria");
      this.showLessAria = this.button.getAttribute("data-show-less-aria");
    }
  }

  _onClickButton(e) {
    e.preventDefault();
    this.container.forEach((cont) => {
      if (!cont.classList.contains("active")) {
        cont.style.display = "flex";
        cont.classList.add("active");
      } else {
        cont.style.display = "none";
        cont.classList.remove("active");
      }
    });
    if (!this.button.classList.contains("active")) {
      this.button.classList.add("active");
      this.button.innerText = this.showLessText;
      this.button.setAttribute('aria-label', this.showLessAria);
      this.container.item(0).parentNode.focus();
    } else {
      this.button.classList.remove("active");
      this.button.setAttribute('aria-label', this.showMoreAria);
      this.button.innerText = this.showMoreText;
    }
  }
}

export default HiddenFilters;
