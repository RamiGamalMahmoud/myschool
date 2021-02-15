import DataTable from '../../lib/datatable.js';

export default function initMonitoringTable() {
  const monitoringTableElement = document.getElementById('monitoring-table');
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
}