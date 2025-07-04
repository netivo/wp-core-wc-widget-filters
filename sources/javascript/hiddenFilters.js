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
    }
  }

  _onClickButton(e) {
    e.preventDefault();
    this.container.forEach((cont) => {
      if (!cont.classList.contains("active")) {
        cont.style.display = "flex";
        cont.classList.add("active");
        this.button.innerText = this.showLessText;
      } else {
        cont.style.display = "none";
        cont.classList.remove("active");
        this.button.innerText = this.showMoreText;
      }
    });
  }
}
export default HiddenFilters;
