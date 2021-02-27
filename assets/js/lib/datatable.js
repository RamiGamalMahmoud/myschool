export default class DataTable {

  constructor(table) {
    this.table = table;
    this.head = this.table.querySelector('.table-head');
    this.headerContent = this.table.querySelector('.table-head .table-head-content');
    this.body = this.table.querySelector('.table-body');
    this.tableBody = this.body.querySelector('.table tbody');
    this.cells = this.body.querySelectorAll('td[contenteditable="true"]');
    this.isScrollable = this.table.getAttribute('scrollable') || false;
  }

  init(url = null, onCellChangeHandler = null) {

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

      cell.addEventListener('focus', function (ev) {

        let selection = window.getSelection();
        let range = document.createRange();

        selection.removeAllRanges();
        range.selectNodeContents(this);
        selection.addRange(range);
      });

      if (url !== null) {
        cell.addEventListener('blur', saveChanges(cell, url, onCellChangeHandler));
      }
      cell.addEventListener('blur', function () {
        cell.classList.remove('active-cell');
        cell.parentElement.classList.remove('active-row');
      });

    });

    let rows = this.body.querySelectorAll('table tbody tr');
    let row = this.body.querySelector('table tbody tr');
    row.focus();
    Array.from(rows).forEach((row) => {
      row.setAttribute('tabindex', '0');
      row.addEventListener('keydown', (ev) => this.rowKeydownHandler(ev, row));
      row.addEventListener('click', (ev) => this.rowKlickedHandler(ev));
    });
  }

  rowKlickedHandler(ev) {
    if (!ev.target.getAttribute('contenteditable')) {
      ev.target.parentNode.focus();
    }
  }

  rowKeydownHandler(ev, row) {
    // prevent arrows from scroll all the page
    let nextRow = null;
    if (ev.key === 'ArrowUp') { // arrow up
      ev.preventDefault();
      nextRow = row.previousSibling;
      nextRow = nextRow !== null && nextRow.nodeName === '#text' ? nextRow.previousSibling : nextRow;
    } else if (ev.key === 'ArrowDown') { // arrow down
      ev.preventDefault();
      nextRow = row.nextSibling;
      nextRow = nextRow !== null && nextRow.nodeName === '#text' ? nextRow.nextSibling : nextRow;
    }

    if (nextRow) {
      nextRow.focus();
    }
  }

  addScrolling() {
    if (this.body !== null && this.head !== null) {
      if (this.headerContent) {
        this.body.addEventListener('scroll', () => this.headerContent.scroll(this.body.scrollLeft, 0));
      } else {
        this.body.addEventListener('scroll', () => this.head.scroll(this.body.scrollLeft, 0));
      }
    }
  }

  /**
   * Insert new row to the table
   * @param array data 
   */
  addRow(data, event = null) {
    let row = this.tableBody.insertRow(), cellContent;
    row.setAttribute('tabindex', 0);

    data.forEach(item => {
      let cell = row.insertCell();
      let events = item['events'];
      if (events !== undefined) {
        events.forEach(event => {
          cell.addEventListener(event.eventName, event.callback);
        })
      }

      // check if the element contains another element the create it
      if (typeof item['cellContent'] === 'object' && item['cellContent'] !== null) {
        cellContent = document.createElement(item['cellContent'].elementType);
        cellContent.innerText = item.cellContent.text;
        let attributes = item['cellContent']['attributes'];
        let events = item['cellContent']['events'];
        for (const attr in attributes) {
          cellContent.setAttribute(attr, attributes[attr]);
        }
      } else {
        cellContent = document.createTextNode(item['cellContent']);
      }
      cell.className = item['className'] === undefined ? '' : item['className'];
      let cellAttributes = item['attributes'];
      for (const attr in cellAttributes) {
        cell.setAttribute(attr, cellAttributes[attr]);
      }
      cell.appendChild(cellContent);
    });

    row.addEventListener('keydown', (ev) => this.rowKeydownHandler(ev, row));
    if (event !== null) {
      row.addEventListener(event.eventName, event.callback);
    }
    return row;
  }

  clearRows() {
    this.tableBody.innerHTML = '';
  }

  show() {
    this.table.style.display = 'block';
  }
  hide() {
    this.table.style.display = 'none';
  }

  getFirstRow() {
    return this.tableBody.rows[0];
  }

  getRows() {
    return this.tableBody.rows;
  }
}

const saveChanges = (cell, url, onCellChangeHandler) => {
  return () => {
    if (cell.getAttribute('dirty') === "true") {
      onCellChangeHandler(cell, url);
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
    ev.preventDefault();
    if (keyCode == 37 && cell.nextElementSibling != null) cell.nextElementSibling.focus();
    if (keyCode == 39 && cell.previousElementSibling != null) cell.previousElementSibling.focus();
  }

  /**
   * The up and down keys
   */
  else if (keyCode == 38 || keyCode == 40) {

    ev.preventDefault();
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
