import { SearchBox, DataTable } from '../../lib';

export default function employeesTable() {
  const dataTableElement = document.querySelector('.employees.data-table');
  if (dataTableElement !== null) {
    const datatable = new DataTable(dataTableElement);
    datatable.init();
  }
};