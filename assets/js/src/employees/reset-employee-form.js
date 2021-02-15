import DataTable from '../lib/datatable.js';

const dataTableElement = document.querySelector('.employees.data-table');
if (dataTableElement !== null) {
  const datatable = new DataTable(dataTableElement);
  datatable.init();
}
const govCombo = document.getElementById('governorate-id');

if (govCombo !== null) {
  govCombo.addEventListener('change', (ev) => {
    getCitiesByGovernorateId(ev.target.value);
  });
}

function getCitiesByGovernorateId(governorateId) {
  let url = `/adderss/cities/by-governorate/${governorateId}`;
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState === 4) {
      if (this.status == 200) {
        let cities = JSON.parse(this.responseText);
        let citiesElement = document.getElementById('city-id');
        citiesElement.textContent = '';
        for (const city of cities) {
          let option = document.createElement('option');
          option.value = city.id;
          option.textContent = city.name;
          citiesElement.appendChild(option);
        }
      }
    }
  };

  xhr.open('GET', url, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send();
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