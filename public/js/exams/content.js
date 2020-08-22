// number from english to indi converter
import DataTable from '/js/lib/datatable.js';

const datatable = new DataTable(document.querySelector('.data-table'));

/**
 * Prepare the link that will be used with the ajax calls
 */
var link = location.toString().replace('/view/', '/save/')

datatable.init(link, function (txt){
    console.log(txt);
});

var parsed = (function () {
    var string = location.search;
    string = string.replace('?', '');
    var parts = string.split('&');
    var obj = {};
    parts.forEach((part) => {
        var line = part.split('=');
        obj[line[0]] = line[1];
    })
    return obj;
})();
console.log(parsed);

let cols = {
    evaluation: [
        "arabic",
        "english",
        "socialStudies",
        "math",
        "sciences",
        "activity_1",
        "activity_2",
        "religion",
        "computer",
        "draw",
        "sports"
    ],
    practical: [
        "sciences",
        "computer"
    ],
    written: [
        "arabic",
        "english",
        "socialStudies",
        "aljebra",
        "geometry",
        "sciences",
        "religion",
        "computer",
        "draw"
    ]
}

const columnSummary = function (colName) {
    var cells = document.querySelectorAll(`.data-table .table-body tr td[colname="${colName}"]`);
    var absens = 0, empty = 0;
    for (let i = 0; i < cells.length; i++) {
        if (cells[i].textContent === 'غ') {
            absens++;
        }
        if (cells[i].textContent === '') {
            empty++;
        }
    }

    return {
        monitoring: `${cells.length - empty}`,
        absens    : `${absens}`,
        empty     : `${empty}`,
        count     : `${cells.length}`
    };

}

if (document.querySelector('.monitoring-summary') != null) {
    var colNames = [];
    if (parsed.view === 'practical') colNames = cols.practical;
    else if (parsed.view === 'evaluation') colNames = cols.evaluation;
    else if (parsed.view === 'written') colNames = cols.written;
    colNames.forEach((colName) => {
        getSummary(colName);
    });
}

function getSummary(colName) {
    const monitoringRow = document.querySelector('tr[rowname="monitoring"]');
    const absenceRow = document.querySelector('tr[rowname="absence"]');

    monitoringRow.querySelector(`td[colname=${colName}]`).textContent = columnSummary(colName).monitoring.toIndiNums();
    absenceRow.querySelector(`td[colname=${colName}]`).textContent = columnSummary(colName).absens.toIndiNums();
}