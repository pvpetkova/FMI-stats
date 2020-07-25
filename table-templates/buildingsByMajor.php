<div class="tab-container">
    <button class="tab" id="table-tab" onclick="drawFMIChart()">ФМИ</button>
    <button class="tab" id="chart-tab" onclick="drawFHFChart()">ФХФ</button>
    <button class="tab" id="chart-tab" onclick="drawFZFChart()">ФЗФ</button>
    <button class="tab" id="chart-tab" onclick="drawBlockChart()">Блок 2</button>
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
    $fmi = $db->getMajorsInFMI();
    $fzf = $db->getMajorsInFZF();
    $fhf = $db->getMajorsInFHF();
    $bl2 = $db->getMajorsInBlock2();
    //tablicite da gi ostavim 4e ina4e nqma kvo da se izteglq?
    ?>
    <div id="fmi" class="">
        <table>
            <tr>
                <th>Специалност</th>
                <th>Брой</th>
            </tr>

            <?php foreach ($fmi as $key => $row): ?>
                <tr>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['cnt']; ?></td>
                </tr>
                <?php
            endforeach;
            ?>
        </table>
        <script>
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawFMIChart);

            function drawFMIChart() {
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
                    foreach ($fmi as $key => $row):
                        echo "['" . $key . "'," . $row . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('fmi'));
                chart.draw(data, options);
            }
        </script>
    </div>

    <div id="fhf" class="">
        <table>
            <tr>
                <th>Специалност</th>
                <th>Брой</th>
            </tr>

            <?php foreach ($fhf as $key => $row): ?>
                <tr>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['cnt']; ?></td>
                </tr>
                <?php
            endforeach;
            ?>
        </table>
        <script>
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawFHFChart);

            function drawFHFChart() {
                var options = {
                    title: 'Дял на специалностите във ФХФ',
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
                        echo "['" . $key . "'," . $row . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('fhf'));
                chart.draw(data, options);
            }
        </script>
    </div>

    <div id="fzf" class="">
        <table>
            <tr>
                <th>Специалност</th>
                <th>Брой</th>
            </tr>

            <?php foreach ($fzf as $key => $row): ?>
                <tr>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['cnt']; ?></td>
                </tr>
                <?php
            endforeach;
            ?>
        </table>
        <script>
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawFZFChart);

            function drawFZFChart() {
                var options = {
                    title: 'Дял на специалностите във ФЗФ',
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
                        echo "['" . $key . "'," . $row . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('fzf'));
                chart.draw(data, options);
            }
        </script>
    </div>

    <div id="block" class="">
        <table>
            <tr>
                <th>Специалност</th>
                <th>Брой</th>
            </tr>

            <?php foreach ($bl2 as $key => $row): ?>
                <tr>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['cnt']; ?></td>
                </tr>
                <?php
            endforeach;
            ?>
        </table>
        <script>
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawBlockChart);

            function drawBlockChart() {
                var options = {
                    title: 'Дял на специалностите във Блок 2',
                    hAxis: {textStyle: {fontSize: 11}},
                    'width': 1000,
                    'height': 400
                };
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Специалност');
                data.addColumn('number', 'Брой');
                data.addRows([
                    <?php
                    foreach ($block as $key => $row):
                        echo "['" . $key . "'," . $row . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('block'));
                chart.draw(data, options);
            }
        </script>
    </div>

</div>
<div class="chart-container bar-chart" id="fmi"></div>
<div class="chart-container bar-chart" id="fzf"></div>
<div class="chart-container bar-chart" id="fhf"></div>
<div class="chart-container bar-chart" id="block"></div>

