class AttributeFilter {
    constructor(selector) {
        this.selector = selector;
        this.filter = this.selector.querySelector('[data-element="filter"]');
        this.checkboxes = this.selector.querySelectorAll('[data-element="checkbox"]');

        this._changeFilter = this._changeFilter.bind(this);

        if (this.filter !== null && this.checkboxes.length > 0) {
            this.checkboxes.forEach(chb => {
                chb.addEventListener('change', this._changeFilter);
            })
        }
    }

    _changeFilter(e) {
        let checkedInp = this.selector.querySelectorAll('[data-element="checkbox"]:checked');
        let checked = [];
        checkedInp.forEach(chk => {
            checked.push(chk.value);
        })
        console.log(checked);
        this.filter.value = checked.join(',');
    }
}

export default AttributeFilter;