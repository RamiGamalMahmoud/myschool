export default class SearchResult {
  constructor(element) {
    this.element = element;
    this.menu = element.querySelector('ul');
    this.element.style.display = 'none';
    this.rows = Array.from(this.menu.querySelectorAll('li'));
  }

  add(data) {
    let li = document.createElement('li');
    let text = document.createTextNode(data.text);
    let attributes = data.attributes;

    if (attributes) {
      attributes.forEach((attribute) => {
        li.setAttribute(attribute.name, attribute.value);
      });
    }

    if (data.childElement !== undefined) {
      let childElement = document.createElement(data.childElement.type);
      let attributes = data.childElement.attributes;
      if (attributes !== undefined) {
        attributes.forEach((attribute) => {
          childElement.setAttribute(attribute.name, attribute.value);
        });
      }
      childElement.appendChild(text);
      li.appendChild(childElement);
    } else {
      li.appendChild(text);
    }

    this.menu.appendChild(li);
    this.rows.push(li);
  }

  show() {
    this.element.style.display = 'block';
    this.clear();
  }

  clear() {
    this.menu.innerHTML = '';
  }

  close() {
    this.element.style.display = 'none';
  }

}