import { Resetable, ResetableFieldset } from '../../lib';

export default function resetEmployeeForm() {
  const employeeForm = document.getElementById('edit-employee-form');
  if (employeeForm === null) {
    return;
  }
  // const formParts = [
  //   new ResetableFieldset(document.getElementById('presonal-data')),
  //   new ResetableFieldset(document.getElementById('employee-status')),
  //   new ResetableFieldset(document.getElementById('social-status')),
  //   new ResetableFieldset(document.getElementById('address')),
  //   new ResetableFieldset(document.getElementById('phone'))
  // ];

  let resetableParts = employeeForm.querySelectorAll('fieldset');
  resetableParts.forEach((part) => {
    part = new ResetableFieldset(part);
  });
}