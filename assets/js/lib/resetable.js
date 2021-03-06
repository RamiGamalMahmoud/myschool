export default class Resetable {

  constructor(element) {
    this.element = element;
    this.setDefaultValue();
  }

  setDefaultValue() {
    if (this.element.getAttribute('type') === 'checkbox') {
      this.defaultValue = this.element.checked;
    } else {
      this.defaultValue = this.element.value;
    }
  }

  reset() {
    this.element.value = this.defaultValue;
    if (this.element.getAttribute('type') === 'checkbox')
      this.element.checked = this.defaultValue;
  }

  addEventListener(event, callable) {
    this.element.addEventListener(event, callable);
  }
}