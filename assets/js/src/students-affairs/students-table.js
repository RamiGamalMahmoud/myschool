import { DataTable } from '../../lib';

export default function studentsTable() {
  const studentsTableElement = document.getElementById('students-table');
  if (studentsTableElement) {
    const studentsTableObject = new DataTable(studentsTableElement);
    studentsTableObject.init();
  }
}