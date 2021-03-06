
export default function editClassrooms() {
  const subjectClassrooms = document.querySelectorAll('fieldset.subject-classrooms');

  subjectClassrooms.forEach((subjectContainer) => {
    const checkedClassrooms = subjectContainer.querySelectorAll('input[checked]');
    const clearClassroomsBtn = subjectContainer.querySelector('.clear-selection');

    clearClassroomsBtn.addEventListener('input', (ev) => {
      if (clearClassroomsBtn.checked === false) {
        checkedClassrooms.forEach((checkbox) => {
          checkbox.checked = true;
        });
        return;
      }
      const checkboxs = subjectContainer.querySelectorAll('.checkbox');
      checkboxs.forEach((checkbox) => {
        checkbox.checked = false;
      });
    });

  });

}