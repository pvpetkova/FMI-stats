<div class="table-container" id="table-container">
    <h2 class="table-name">Разпределение на групите по сгради</h2>
    <div class="download-form">
        <label>Изтегли като: </label>
        <button class="download-button" id="download" value="csv"
                onclick="downloadCsv('buildings')">.csv
        </button>
    </div>

    <?php
    $fmi = $db->getGroupsInFMI();
    $fzf = $db->getGroupsInFZF();
    $fhf = $db->getGroupsInFHF();
    $bl2 = $db->getGroupsInBl2();
    ?>
    <div id="fmi-container" class="">
        <script>
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawFMIChart);

            function drawFMIChart() {
                var options = {
                    title: 'Дял на групите във ФМИ',
                    hAxis: {textStyle: {fontSize: 11}},
                    'width': 1000,
                    'height': 400
                };
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Специалност');
                data.addColumn('number', 'Брой');
                data.addRows([
                    <?php
                    foreach ($fmi as $key => $row):
                        echo "['" . $row['major'] . " " . $row['degree'] . " " . $row['years'] . " " . $row['stream'] . " "  . $row['group_number'] . "'," . $row['cnt'] . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('fmi'));
                chart.draw(data, options);
            }
        </script>
    </div>

    <div id="fhf-container" class="">
        <script>
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawFHFChart);

            function drawFHFChart() {
                var options = {
                    title: 'Дял на групите във ФХФ',
                    hAxis: {textStyle: {fontSize: 11}},
                    'width': 1000,
                    'height': 400
                };
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Специалност');
                data.addColumn('number', 'Брой');
                data.addRows([
                    <?php
                    foreach ($fhf as $key => $row):
                        echo "['" . $row['major'] . " " . $row['degree'] . " " . $row['years'] . " " . $row['stream'] . " " . $row['group_number'] . "'," . $row['cnt'] . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('fhf'));
                chart.draw(data, options);
            }
        </script>
    </div>

    <div id="fzf-container" class="">
        <script>
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawFZFChart);

            function drawFZFChart() {
                var options = {
                    title: 'Дял на групите във ФЗФ',
                    hAxis: {textStyle: {fontSize: 11}},
                    'width': 1000,
                    'height': 400
                };
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Специалност');
                data.addColumn('number', 'Брой');
                data.addRows([
                    <?php
                    foreach ($fzf as $key => $row):
                        echo "['" . $row['major'] . " " . $row['degree'] . " " . $row['years'] . " " . $row['stream'] . " " . $row['group_number'] . "',"  . $row['cnt'] . "],";
                    endforeach;
                    ?>
                ]);
                console.log(data);
                var chart = new google.visualization.ColumnChart(document.getElementById('fzf'));
                chart.draw(data, options);
            }
        </script>
    </div>

    <div id="block-container" class="">
        <script>
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawBlockChart);

            function drawBlockChart() {
                var options = {
                    title: 'Дял на групите във Блок 2',
                    hAxis: {textStyle: {fontSize: 11}},
                    'width': 1000,
                    'height': 400
                };
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Специалност');
                data.addColumn('number', 'Брой');
                data.addRows([
                    <?php
                    foreach ($bl2 as $key => $row):
                        echo "['" . $row['major'] . " " . $row['degree'] . " " . $row['years'] . " " . $row['stream'] . " " . $row['group_number'] . "',"  . $row['cnt'] . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('block'));
                chart.draw(data, options);
            }
        </script>
    </div>
</div>

<div class="chart-container bar-chart" id="fzf"></div>
<div class="chart-container bar-chart" id="fhf"></div>
<div class="chart-container bar-chart" id="block"></div>
<div class="chart-container bar-chart" id="fmi"></div>
