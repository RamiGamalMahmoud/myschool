import DataTable from '../../lib/datatable.js';

export default function initSheet() {
  const sheetElement = document.getElementById('sheet');

  if (sheetElement !== null) {
    const sheet = new DataTable(sheetElement);
    sheet.init();
  }
}