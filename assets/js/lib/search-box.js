import { SearchResult } from './';

export default class SearchBox {
  constructor(searchElement, searchResult, url, onSuccess = null) {
    this.container = searchElement;
    this.searchResult = new SearchResult(searchResult);
    this.url = url;
    this.onSuccess = onSuccess;
    this.init();
  }

  init() {
    this.searchBox = this.container.querySelector('input[type="text"]');
    this.searchBox.addEventListener('input', ev => {
      this.inputHandler(ev, this.onSuccess);
      this.searchResult.show();
    });

    this.container.addEventListener('keyup', ev => {
      if (ev.key === 'Escape') {
        this.searchResult.close();
      }
    });

    this.searchBox.addEventListener('click', ev => {
      this.searchResult.show();
    });
  }

  inputHandler(ev, func) {
    this.search(ev, func);
  }

  search(ev, func) {
    const xhr = new XMLHttpRequest();
    let url = `${this.url}?name=${ev.target.value}`;

    xhr.onreadystatechange = function () {
      if (this.readyState === 4) {
        if (this.status == 200) {
          func(this.responseText);
        }
      }
    };

    xhr.open('GET', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('name=rami');
  }

}