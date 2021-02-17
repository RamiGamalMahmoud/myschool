export default class Resetable {

  constructor(element) {
    this.element = element;
    this.defaultValue = element.value;
  }

  reset() {
    this.element.value = this.defaultValue;
  }

  addEventListener(event, callable) {
    this.element.addEventListener(event, callable);
  }
}