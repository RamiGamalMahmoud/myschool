import { DataTable } from '../../lib';

export default function absenceTable() {
  const absenceDataTable = document.getElementById('absence-table');
  if (absenceDataTable) {
    const absenceCells = document.querySelectorAll('.absence-cell');

    Array.from(absenceCells).forEach((cell) => {
      cell.addEventListener('dblclick', (ev) => {
        updateAbsenceState(cell);
        if (cell.textContent === 'x') {
          cell.textContent = '';
          cell.classList.remove('danger');
        } else {
          cell.textContent = 'x';
          cell.classList.add('danger');
        }
      });
    });
  }
  const updateAbsenceState = (cell) => {
    const daysNumbers = absenceDataTable.querySelector('.days-numbers-row').cells;
    let year = document.getElementById('year').value;
    let month = document.getElementById('month').value;
    const day = daysNumbers[cell.cellIndex - 4].textContent;

    let data = {
      studentId: cell.parentNode.querySelector("[student-id]").getAttribute('student-id'),
      date: `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`,
      status: cell.textContent ? 0 : 1
    };
    sendData(data);
  };

  const sendData = (data) => {
    let url = `/students-affairs/absence/register/${data.studentId}`;
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        console.log(this.responseText);
      }
    };
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(data));
  };
}
