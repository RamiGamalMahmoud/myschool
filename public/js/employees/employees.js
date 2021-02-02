import DataTable from '/js/lib/datatable.js';

const dataTableElement = document.querySelector('.employees.data-table');
if (dataTableElement !== null) {
  const datatable = new DataTable(dataTableElement);
  datatable.init();
}
const govCombo = document.getElementById('governorate');

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
        let citiesElement = document.getElementById('city');
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