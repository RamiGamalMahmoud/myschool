import employeesTable from './employees-table';
import updateCities from './update-cities';
import resetEmployeeForm from './reset-employee-form';
import employeeSearch from './employee-search';

(function () {
  if (document.querySelector('.employees-data')) {
    employeesTable();
    updateCities();
    resetEmployeeForm();
    employeeSearch();
  }
}())