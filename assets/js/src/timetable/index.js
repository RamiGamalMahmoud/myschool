import editClassrooms from './edit-teacher-classrooms';
import teacherTable from './teacher-table';
import savePeriod from './timetable';

(function () {
  if (document.getElementById('timetable-content')) {
    teacherTable();
    editClassrooms();
    savePeriod();
  }
}());