import { Resetable } from './';

export default class ResetableFieldset {
  constructor(fieldset) {
    this.fieldset = fieldset;
    this.resetButton = this.fieldset.querySelector('.reset-btn');
    this.isDirty = this.fieldset.querySelector('.is-dirty');
    this.setResetableItems();
  }

  setResetableItems() {
    this.resetablesItems = Array.from(this.fieldset.querySelectorAll('.resetable')).map((item) => {
      return new Resetable(item);
    });
    this.assignEvent();
    this.reset();
  }

  assignEvent() {
    this.resetablesItems.forEach((item) => {
      item.addEventListener('input', () => {
        this.resetButton.style.visibility = 'visible';
        this.isDirty.value = '1';
      });
    });
  }

  reset() {
    this.resetButton.addEventListener('click', (ev) => {
      ev.preventDefault();
      this.resetablesItems.forEach((item) => {
        item.reset();
      });
      this.resetButton.style.visibility = 'hidden';
      this.isDirty.value = '0';
    });
  }
}