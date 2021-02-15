export default class DataTable {

  constructor(table) {
    this.table = table;
    this.head = this.table.querySelector('.table-head');
    this.body = this.table.querySelector('.table-body');
    this.cells = this.body.querySelectorAll('td');
    this.isScrollable = this.table.getAttribute('scrollable') || false;
  }

  init(link = null, callback = null) {

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

      if (link !== null) {
        cell.addEventListener('blur', saveChanges(cell, link, callback));
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

const saveChanges = (cell, link, callback = null) => {
  return () => {
    if (cell.getAttribute('dirty') == "true") {

      // The data objet that will be sint via POST request
      let data = {
        id: '',
        subjectName: '',
        degree: ''
      }

      // initialize the data object
      let table = document.getElementById('monitoring-table');
      let head = table.querySelector('.table-head .table tr:nth-of-type(2)');
      let index = cell.cellIndex;
      let subjectName = head.children[index].getAttribute('subject-name');
      let degree = cell.textContent;

      if (degree === '') {
        alert('empty');
        degree = null;
      } else if (isNaN(parseFloat(degree))) {
        degree = -1;
      }

      data.id = cell.parentElement.querySelector('[studentId]').getAttribute('studentId');
      data.degree = degree;
      data.subjectName = subjectName;

      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (this.readyState === 4) {
          if (this.status == 200) {
            console.log(data);
            console.log(this.responseText);
            let deg = JSON.parse(this.responseText)['degree'];
            if (deg < 0) {
              cell.textContent = 'غ';
              cell.classList.add('warning');
            } else {
              cell.textContent = deg;
              cell.classList.remove('warning');
            }
            cell.textContent = deg < 0 ? 'غ' : deg;
            cell.classList.remove('danger');
            cell.setAttribute('dirty', false);
          } else {
            alert(JSON.parse(this.responseText)['message']);
            cell.textContent = cell.getAttribute('old-value');
            cell.setAttribute('old-value', cell.textContent);
            cell.classList.add('danger');
          }
        }
      };

      // Sending the POST request
      xhr.open('POST', link, true);
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
