
export default function updateCities() {
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
}