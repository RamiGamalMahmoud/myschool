import { XHR, flash } from '../../lib';

export default function savePeriod() {
  const mainTimetable = document.getElementById('main-table');
  if (mainTimetable) {
    const periodsCells = mainTimetable.querySelectorAll('td select');
    periodsCells.forEach((cell) => {
      const attributes = {
        oldValue: cell.value,
        backgroundColor: cell.style.backgroundColor
      }
      cell.addEventListener('input', () => {
        save(cell, attributes);
      });

      cell.addEventListener('dblclick', () => {
        cell.value = '0';
        save(cell, 0);
      });
    });

    const save = (cell, attributes) => {
      const dataElement = cell.parentElement.parentElement.querySelector('[teacher-id]');
      let data = {
        classroomId: cell.value,
        teacherId: dataElement.getAttribute('teacher-id'),
        subjectId: dataElement.getAttribute('subject-id'),
        dayId: cell.parentElement.getAttribute('day-id'),
        periodId: cell.parentElement.getAttribute('period-id')
      }
      const xhr = new XHR('POST', '/timetable/period/update');
      xhr.onSuccess((text) => {
        cell.style.backgroundColor = 'rgba(37, 111, 48, .3)';
        setTimeout(() => {
          cell.style.backgroundColor = attributes.backgroundColor;
        }, 1000);
      });

      xhr.onFail((text) => {

        flash(cell, 10, () => {
          cell.value = attributes.oldValue;
        }, [attributes.backgroundColor, 'red', attributes.backgroundColor]);
      });
      xhr.setHeader('Content-Type', 'application/json');
      xhr.send(JSON.stringify(data));
    }
  }
}