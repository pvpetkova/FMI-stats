<div class="tab-container">
    <button class="tab tab-active" id="table-tab" onclick="showTable('buildings')">Таблица</button>
    <button class="tab" id="chart-tab" onclick="showChart('buildings')">Графика</button>
</div>
<div class="table-container" id="table-container">
    <h2 class="table-name">Разпределение на специалностите по сгради</h2>
    <div class="download-form">
        <label>Изтегли като: </label>
        <button class="download-button" id="download" value="csv"
                onclick="downloadCsv('buildings')">.csv
        </button>
    </div>

    <?php
    $size = count($tableData);
    $keys = array();
    $values = array();
    $fmi = $db->getMajorsInBuilding('ФМИ');
    $fzf = $db->getMajorsInBuilding('ФЗФ');
    $fhf = $db->getMajorsInBuilding('ФХФ');
    $bl2 = $db->getMajorsInBuilding('Блок 2');

    foreach ($fmi as $key => $row) {
        array_push($keys, $row['major']);
        array_push($values, $row['cnt']);
    }

    // TODO:  draw the other charts from the rest of the arrays

    $fmiDataPoints = array_combine($keys, $values);
    ?>

    <script>
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var options = {
                title: 'Дял на специалностите във ФМИ',
                hAxis: {textStyle: {fontSize: 11}},
                'width': 1000,
                'height': 400
            };
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Специалност');
            data.addColumn('number', 'Брой');
            data.addRows([
                <?php
                foreach ($fmiDataPoints as $key => $row):
                    echo "['" . $key . "'," . $row . "],";
                endforeach;
                ?>
            ]);
            var chart = new google.visualization.ColumnChart(document.getElementById('fmi'));
            chart.draw(data, options);
        }
    </script>


</div>
<div class="chart-container bar-chart" id="fmi"></div>
<div class="chart-container bar-chart" id="fzf"></div>
<div class="chart-container bar-chart" id="fhf"></div>
<div class="chart-container bar-chart" id="blok2"></div>