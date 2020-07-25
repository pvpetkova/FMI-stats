var config;

function loadJSON(callback) {
    var req = new XMLHttpRequest();
    req.overrideMimeType("application/json");
    req.open('GET', 'config.json', true);
    // Replace 'my_data' with the path to your file
    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            // Required use of an anonymous callback
            // as .open() will NOT return a value but simply returns undefined in asynchronous mode
            callback(req.responseText);
        }
    };
    req.send(null);
}

loadJSON(function (response) {
    config = JSON.parse(response);
});

function downloadCsv(grouping) {
    var req = new XMLHttpRequest();
    req.onload = function () {
        console.log(this.responseText);
        var csvContent = "data:text/csv;charset=utf-8,";
        var json = JSON.parse(this.responseText);
        var fields = Object.keys(json[0]);
        var replacer = function (key, value) {
            return value === null ? '' : value
        };
        var csv = json.map(function (row) {
            return fields.map(function (fieldName) {
                return JSON.stringify(row[fieldName], replacer)
            }).join(',')
        });
        csv.unshift(fields.join(','));
        csv = csv.join('\r\n');

        var encodedUri = encodeURI(csvContent + csv);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "my_data.csv");
        document.body.appendChild(link);

        link.click();
    };

    var url = "http://" + config.serverHost + ':' + config.serverPort +
        config.projectFolderRelative + 'index.php';
    console.log(url);
    if (grouping) {
        url = url + "?grouping=" + grouping + "&json=true";
    } else {
        url = url + "&json=true";
    }
    req.open("get", url, true);
    req.send();
}

function showTable(chartId) {
    var tableContainer = document.getElementById('table-container');
    var chartContainer = document.getElementById(chartId);
    tableContainer.removeAttribute("hidden");
    chartContainer.setAttribute("hidden", '');

    var tableTab = document.getElementById('table-tab');
    var chartTab = document.getElementById('chart-tab');
    tableTab.classList.add('tab-active');
    chartTab.classList.remove('tab-active');
}

function showChart(chartId) {
    var tableContainer = document.getElementById('table-container');
    var chartContainer = document.getElementById(chartId);
    chartContainer.removeAttribute("hidden");
    tableContainer.setAttribute("hidden", '');

    var tableTab = document.getElementById('table-tab');
    var chartTab = document.getElementById('chart-tab');
    tableTab.classList.remove('tab-active');
    chartTab.classList.add('tab-active');
}

function showFMIinfo() {
    var neededContainer = document.getElementById('fmi-container');
    var o1 = document.getElementById('fhf-container');
    var o2 = document.getElementById('fzf-container');
    var o3 = document.getElementById('block-container');
    neededContainer.removeAttribute("hidden");
    o1.setAttribute("hidden", '');
    o2.setAttribute("hidden", '');
    o3.setAttribute("hidden", '');

    var neededTab = document.getElementById('fmi-tab');
    var o1tab = document.getElementById('fhf-tab');
    var o2tab = document.getElementById('fzf-tab');
    var o3tab = document.getElementById('bl2-tab');
    neededTab.classList.add('tab-active');
    o1tab.classList.remove('tab-active');
    o2tab.classList.remove('tab-active');
    o3tab.classList.remove('tab-active')
}

function showFZFinfo() {
    var o1 = document.getElementById('fmi-container');
    var neededContainer = document.getElementById('fhf-container');
    var o2 = document.getElementById('fzf-container');
    var o3 = document.getElementById('block-container');
    neededContainer.removeAttribute("hidden");
    o1.setAttribute("hidden", '');
    o2.setAttribute("hidden", '');
    o3.setAttribute("hidden", '');

    var o1tab = document.getElementById('fmi-tab');
    var neededTab = document.getElementById('fhf-tab');
    var o2tab = document.getElementById('fzf-tab');
    var o3tab = document.getElementById('bl2-tab');
    neededTab.classList.add('tab-active');
    o1tab.classList.remove('tab-active');
    o2tab.classList.remove('tab-active');
    o3tab.classList.remove('tab-active')
}

function showFHFinfo() {
    var o1 = document.getElementById('fmi-container');
    var o2 = document.getElementById('fhf-container');
    var neededContainer = document.getElementById('fzf-container');
    var o3 = document.getElementById('block-container');
    neededContainer.removeAttribute("hidden");
    o1.setAttribute("hidden", '');
    o2.setAttribute("hidden", '');
    o3.setAttribute("hidden", '');

    var o1tab = document.getElementById('fmi-tab');
    var o2tab = document.getElementById('fhf-tab');
    var neededTab = document.getElementById('fzf-tab');
    var o3tab = document.getElementById('bl2-tab');
    neededTab.classList.add('tab-active');
    o1tab.classList.remove('tab-active');
    o2tab.classList.remove('tab-active');
    o3tab.classList.remove('tab-active')
}

function showBlok2info() {
    var o1 = document.getElementById('fmi-container');
    var o2 = document.getElementById('fzf-container');
    var o3 = document.getElementById('fhf-container');
    var neededContainer = document.getElementById('block-container');
    neededContainer.removeAttribute("hidden");
    o1.setAttribute("hidden", '');
    o2.setAttribute("hidden", '');
    o3.setAttribute("hidden", '');

    var o1tab = document.getElementById('fmi-tab');
    var o2tab = document.getElementById('fzf-tab');
    var o3tab = document.getElementById('fhf-tab');
    var neededTab = document.getElementById('bl2-tab');
    neededTab.classList.add('tab-active');
    o1tab.classList.remove('tab-active');
    o2tab.classList.remove('tab-active');
    o3tab.classList.remove('tab-active')
}