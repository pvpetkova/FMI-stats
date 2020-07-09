function downloadCsv(grouping) {

    var req = new XMLHttpRequest();
    req.onload = function () {
        var csvContent = "data:text/csv;charset=utf-8,";
        console.log(JSON.parse(this.responseText));
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

    var url = "data.php";
    if (grouping) {
        url = url + "?grouping=" + grouping;
    }
    req.open("get", url, true);
    req.send();
}
