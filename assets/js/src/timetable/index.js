import editClassrooms from './edit-teacher-classrooms';
import teacherTable from './teacher-table';

(function () {
  if (document.getElementById('timetable-content')) {
    teacherTable();
    editClassrooms();
  }
}());