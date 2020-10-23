export default class DataTable {

  constructor(table) {
    this.table = table;
    this.head = this.table.querySelector('.table-head');
    this.body = this.table.querySelector('.table-body');
    this.cells = this.body.querySelectorAll('td');
    this.isScrollable = this.table.getAttribute('scrollable') || false;
  }

  init(ajaxLink = null, callback = null) {

    this.addScrolling();

    this.cells.forEach(function (cell) {
      cell.addEventListener('keydown', function (ev) {
        keyDownHandler(ev.keyCode, cell, ev);
      });

      cell.addEventListener('input', function () {
        cell.setAttribute('dirty', true);
      });

      cell.addEventListener('focus', function () {
        cell.setAttribute('old-value', cell.textContent);
        cell.classList.add('active-cell');
        cell.parentElement.classList.add('active-row');
      });

      cell.addEventListener('focus', function () {
        let range = document.createRange();
        range.selectNodeContents(this);

        let selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
      });

      if (ajaxLink !== null) {
        cell.addEventListener('blur', saveChanges(cell, ajaxLink, callback));
      }
      cell.addEventListener('blur', function () {
        cell.classList.remove('active-cell');
        cell.parentElement.classList.remove('active-row');
      });

    });
  }

  addScrolling() {
    if (this.body !== null && this.head !== null) {
      this.body.scrollTo(this.body.scrollWidth, 0);
      this.body.addEventListener('scroll', () => this.head.scroll(this.body.scrollLeft, 0));
    }
  }
}

const saveChanges = function (cell, ajaxLink, callback = null) {
  return () => {
    if (cell.getAttribute('dirty') == "true") {

      // The data objet that will be sint via POST request
      let data = {
        id: '',
        dataName: '',
        dataValue: ''
      }
      // initialize the data object
      data.dataName = cell.getAttribute('dataName');
      data.id = cell.parentElement.querySelector('[dataname="studentId"]').textContent;
      data.dataValue = cell.textContent;

      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          cell.setAttribute('dirty', false);
          cell.textContent = this.responseText;

          // Call the callback function
          if (typeof (callback) === 'function' && callback !== null) {
            callback(cell);
          }
        } else {
          cell.textContent = cell.getAttribute('old-value');
          cell.setAttribute('old-value', cell.textContent);
          cell.classList.add('error');
        }
      };
      // Sending the POST request
      xhr.open('POST', ajaxLink, true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.send(JSON.stringify(data));
    }
  }
}

const keyDownHandler = function (keyCode, cell, ev) {

  /**
   * The enter key
   */
  if (keyCode == 13) {
    ev.preventDefault();

    cell.blur();
    keyCode = 40;
  }

  /**
   * The escape key
   */
  if (keyCode == 27) {
    cell.textContent = cell.getAttribute('old-value');
    cell.setAttribute('old-value', '');
    cell.setAttribute('dirty', false);
    cell.blur();
    return;
  }

  /**
   * The arrow keys
   */
  let currentRow = cell.parentElement;
  let nextRow = null;
  let currentIndex = -1;

  /**
   * The left and right keys
   */
  if (keyCode == 37 || keyCode == 39) {
    if (keyCode == 37 && cell.nextElementSibling != null) cell.nextElementSibling.focus();
    if (keyCode == 39 && cell.previousElementSibling != null) cell.previousElementSibling.focus();
  }

  /**
   * The up and down keys
   */
  else if (keyCode == 38 || keyCode == 40) {

    for (let i = 0; i < currentRow.childElementCount; i++) {
      if (cell == currentRow.children[i]) {
        currentIndex = i;
        break;
      }
    }

    if (keyCode == 38) {
      nextRow = currentRow.previousElementSibling;
    } else if (keyCode == 40) {
      nextRow = currentRow.nextElementSibling;
    }

    if (nextRow && nextRow.children[currentIndex]) {
      nextRow.children[currentIndex].focus();
    }
  } else return;
}
