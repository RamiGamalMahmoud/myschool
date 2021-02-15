
export default function resetEmployeeForm() {
  const employeeForm = document.getElementById('edit-employee-form');
  if (employeeForm === null) {
    return;
  }
  const formParts = {
    presonalPart: document.getElementById('presonal-data'),
    employeeStatus: document.getElementById('employee-status'),
    socialStatus: document.getElementById('social-status'),
    address: document.getElementById('address'),
    phone: document.getElementById('phone')
  };

  for (const fieldSet in formParts) {
    let selectElements = formParts[fieldSet].querySelectorAll('select');
    let resetButton = formParts[fieldSet].querySelector('.reset-btn');

    for (let i = 0; i < selectElements.length; i++) {
      selectElements[i].addEventListener('input', (ev) => {
        if (resetButton !== null)
          resetButton.style.visibility = 'visible';
      });
    }
  }

  const resetButtons = document.querySelectorAll('.reset-btn');

  for (const resetButton of resetButtons) {
    resetButton.addEventListener('click', (ev) => {
      ev.preventDefault();
    });
  }
}