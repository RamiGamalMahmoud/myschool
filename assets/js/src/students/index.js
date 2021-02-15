

const saveChanges = function (cell) {
    return () => {
        if (cell.getAttribute('dirty') == "true") {

            // The data objet that will be sint via POST request
            let data = {
                ajax: true,
                id: '',
                dataName: '',
                dataValue: ''
            }
            // initialize the data object
            data.dataName = cell.getAttribute('dataName');
            data.id = cell.parentElement.querySelector('[dataname="studentId"]').textContent;
            data.dataValue = cell.textContent;
            
            // Sending the POST request
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    cell.setAttribute('dirty', false);
                    cell.textContent = this.responseText;
                }else{
                    cell.textContent = cell.getAttribute('old-value');
                    cell.setAttribute('old-value', cell.textContent);
                }
            };
            xhr.open('POST', 'http://www.schl-dev.com:8080/admin/students/edit', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify(data));
        }
    }
}
// #######################################
const keyDownHandler = (keyCode, cell, ev) => {

    
    if (keyCode == 13) { //enter key
        ev.preventDefault();

        cell.blur();
        keyCode = 40;
    }
    if (keyCode == 27) { // escape key
        cell.childNodes[0].textContent = cell.getAttribute('old-value');
        cell.setAttribute('old-value', '');
        cell.setAttribute('dirty', false);
        cell.blur();
        return;
    }

    // the arrow keys handler

    let currentRow = cell.parentElement;
    let nextRow = null;
    let currentIndex = -1;

    if (keyCode == 37 || keyCode == 39) { // left and right
        if (keyCode == 37 && cell.nextElementSibling != null) cell.nextElementSibling.focus();
        if (keyCode == 39 && cell.previousElementSibling != null) cell.previousElementSibling.focus();

    }

    else if (keyCode == 38 || keyCode == 40) { // up and down

        for (let i = 0; i < currentRow.childElementCount; i++) {
            if (cell == currentRow.childNodes[i]) {
                currentIndex = i;
                break;
            }
        }

        if (keyCode == 38) {
            nextRow = currentRow.previousElementSibling;
        } else if (keyCode == 40) {
            nextRow = currentRow.nextElementSibling;
        }

        if (nextRow != null) nextRow.childNodes[currentIndex].focus();
    } else return;
}

let cells = document.querySelectorAll('.students-data tbody td');

cells.forEach((cell) => {
    cell.addEventListener('keydown', (ev) => {
        keyDownHandler(ev.keyCode, cell, ev);
    });
    cell.addEventListener('input', () => {
        cell.setAttribute('dirty', true);
    })

    cell.addEventListener('focus', function () {
        cell.setAttribute('old-value', cell.textContent);
    })

    cell.addEventListener('blur', saveChanges(cell));
});


// Scroll Data Table
let body = document.querySelector('.data .table-body');
let head = document.querySelector('.data .table-head');
if (body != null) {
    body.scrollTo(body.scrollWidth, 0)
    body.addEventListener('scroll', function (ev) {
        head.scroll(body.scrollLeft, 0);
    });

    head.addEventListener('scroll', function (ev) {
        body.scroll(ev.target.scrollLeft, body.scrollTop);
    });
}


// Add New Student
/*
    1- check if the length = 14 & its value is not NaN  #its a number
    2- get the sex-value, pirth-year, pirth-month, pirth-day, pirth-century, pirth-state
*/
let idField = document.querySelector('.add-student-form #national-id');
if (idField) {
    idField.addEventListener('input', function () {
        let value = idField.value;
        if (!isNaN(value) && value.length == 14) {
            idField.classList.remove('error');

            let nationalData = {
                sex: value[12] % 2 == 0 ? 'أنثى' : 'ذكر',
                pirthYear: parseInt(value.substring(1, 3)),
                pirthMonth: parseInt(value.substring(3, 5)),
                pirthDay: parseInt(value.substring(5, 7)),
                pirthCentury: parseInt(value[0]),
                pirthState: parseInt(value.substring(7, 9))
            };


            nationalData.pirthYear += nationalData.pirthCentury < 3 ? 1900 : 2000;
            nationalData.pirthDate = new Date(nationalData.pirthYear, nationalData.pirthMonth - 1, nationalData.pirthDay);
            let calcDate = new Date('2019-10-1');
            let studentAge = calcAge(calcDate, nationalData.pirthDate);
            // fields to extract data
            // sexField, pirthDateField, pirthDayField, pirthMonthField, pirthYearField

            document.getElementById('sex').value = nationalData.sex;
            document.getElementById('pirth-date').value = nationalData.pirthDate.getFullYear() + '/' + (nationalData.pirthDate.getMonth() + 1) + '/' + nationalData.pirthDate.getDate();

            document.getElementById('pirth-day').value = studentAge.days;
            document.getElementById('pirth-month').value = studentAge.months;
            document.getElementById('pirth-year').value = studentAge.years;


            console.log(studentAge);
        } else {
            idField.classList.add('error');
        }
    });
}
function calcAge(calcDate, pirthDate) {
    let dif = new Date(calcDate.getTime() - pirthDate.getTime());

    return {
        days: dif.getDate(),
        months: dif.getMonth(),
        years: dif.getFullYear() - 1970
    }
}