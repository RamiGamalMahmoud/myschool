// number from english to indi converter
import DataTable from '/js/lib/datatable.js';

const monitoringTableElement = document.getElementById('monitoring-table');
const sheetElement = document.getElementById('sheet');

if (sheet !== null) {
  const sheet = new DataTable(sheetElement);
  sheet.init();
}

if (monitoringTableElement !== null) {
  const datatable = new DataTable(monitoringTableElement);

  let url = location.toString();
  datatable.init(url, function (cell) {
    if (cell.textContent < 0 || cell.textContent === 'غ') {
      cell.textContent = 'غ';
      cell.classList.add('warning');
    } else {
      cell.classList.remove('warning');
    }
  });
}

let parsed = (function () {
  let string = location.search;
  string = string.replace('?', '');
  let parts = string.split('&');
  let obj = {};
  parts.forEach((part) => {
    let line = part.split('=');
    obj[line[0]] = line[1];
  })
  return obj;
})();

let cols = {
  evaluation: [
    "arabic",
    "english",
    "socialStudies",
    "math",
    "sciences",
    "activity_1",
    "activity_2",
    "religion",
    "computer",
    "draw",
    "sports"
  ],
  practical: [
    "sciences",
    "computer"
  ],
  written: [
    "arabic",
    "english",
    "socialStudies",
    "aljebra",
    "geometry",
    "sciences",
    "religion",
    "computer",
    "draw"
  ]
}

const columnSummary = function (colName) {
  let cells = document.querySelectorAll(`.data-table .table-body tr td[colname="${colName}"]`);
  let absens = 0, empty = 0;
  for (let i = 0; i < cells.length; i++) {
    if (cells[i].textContent === 'غ') {
      absens++;
    }
    if (cells[i].textContent === '') {
      empty++;
    }
  }

  return {
    monitoring: `${cells.length - empty}`,
    absens: `${absens}`,
    empty: `${empty}`,
    count: `${cells.length}`
  };

}

if (document.querySelector('.monitoring-summary') != null) {
  let colNames = [];
  if (parsed.view === 'practical') colNames = cols.practical;
  else if (parsed.view === 'evaluation') colNames = cols.evaluation;
  else if (parsed.view === 'written') colNames = cols.written;
  colNames.forEach((colName) => {
    getSummary(colName);
  });
}

function getSummary(colName) {
  const monitoringRow = document.querySelector('tr[rowname="monitoring"]');
  const absenceRow = document.querySelector('tr[rowname="absence"]');

  monitoringRow.querySelector(`td[colname=${colName}]`).textContent = columnSummary(colName).monitoring.toIndiNums();
  absenceRow.querySelector(`td[colname=${colName}]`).textContent = columnSummary(colName).absens.toIndiNums();
}