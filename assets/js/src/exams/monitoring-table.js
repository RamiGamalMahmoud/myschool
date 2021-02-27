import DataTable from '../../lib/datatable.js';

export default function initMonitoringTable() {
  const monitoringTableElement = document.getElementById('monitoring-table');
  if (monitoringTableElement !== null) {
    const datatable = new DataTable(monitoringTableElement);

    datatable.init(location.toString(), function (cell, url) {
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
      xhr.open('POST', url, true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.send(JSON.stringify(data));
    });
  }
}