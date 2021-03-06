import { DataTable } from './lib';

(function () {
  let dataTables = document.querySelectorAll('.data-table');
  if (dataTables) {
    Array.from(dataTables).forEach((element) => {
      let dataTable = new DataTable(element);
      dataTable.init();
    });
  }
})();

import './src/employees';
import './src/students-affairs';
import './src/exams';
import './src/timetable';
import './src/login.js';
