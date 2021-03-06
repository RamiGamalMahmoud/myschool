export default class XHR {
  constructor(method, url) {
    this.method = method;
    this.url = url;
    this.contentTypes = [];

    this.xhr = new XMLHttpRequest();
    this.xhr.open(this.method, this.url);
  }

  setHeader(name, value) {
    this.xhr.setRequestHeader(name, value);
  }

  onSuccess(callable) {
    this.xhr.addEventListener('readystatechange', function () {
      if (this.readyState === 4 && this.status === 200) {
        callable(this.responseText);
      }
    });
  }

  onFail(callable) {
    this.xhr.addEventListener('readystatechange', function () {
      if (this.readyState !== 4 || this.status !== 200) {
        callable();
      }
    });
  }

  send(data = null) {
    this.xhr.send(data);
  }
}