<div class="tab-container">
    <button class="tab" id="table-tab" onclick="drawFMIChart()">ФМИ</button> <!--mai gi opleskah malko-->
    <button class="tab" id="chart-tab" onclick="drawFHFChart()">ФХФ</button>
    <button class="tab" id="chart-tab" onclick="drawFZFChart()">ФЗФ</button>
    <button class="tab" id="chart-tab" onclick="drawBlockChart()">Блок 2</button>
</div>
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
    $bl2 = $db->getGroupsInBlock2();
    //tablicite da gi ostavim 4e ina4e nqma kvo da se izteglq?
    ?>
    <div id="fmi" class="">
        <table>
            <tr>
                <th>Специалност</th>
                <th>Степен</th>
                <th>Курс</th>
                <th>Поток</th>
                <th>Група</th>
                <th>Брой</th>
            </tr>

            <?php foreach ($fmi as $key => $row): ?>
                <tr>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['degree']; ?></td>
                    <td><?php echo $row['years']; ?></td>
                    <td><?php echo $row['stream']; ?></td>
                    <td><?php echo $row['group_number']; ?></td>
                    <td><?php echo $row['cnt']; ?></td>
                </tr>
                <?php endforeach; ?>
        </table>
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
                data.addColumn('string', 'Степен');
                data.addColumn('number', 'Курс');
                data.addColumn('number', 'Поток');
                data.addColumn('number', 'Група');
                data.addColumn('number', 'Брой');
                data.addRows([
                    <?php
                    foreach ($fmiDataPoints as $key => $row):
                        echo "['" . $row['major'] . "','" . $row['degree'] . "'," . $row['year'] . "," . $row['stream'] . "," . $row['group_number'] . "," . $row['cnt'] . "],";
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
                <th>Степен</th>
                <th>Курс</th>
                <th>Поток</th>
                <th>Група</th>
                <th>Брой</th>
            </tr>

            <?php foreach ($fhf as $key => $row): ?>
                <tr>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['degree']; ?></td>
                    <td><?php echo $row['years']; ?></td>
                    <td><?php echo $row['stream']; ?></td>
                    <td><?php echo $row['group_number']; ?></td>
                    <td><?php echo $row['cnt']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
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
                data.addColumn('string', 'Степен');
                data.addColumn('number', 'Курс');
                data.addColumn('number', 'Поток');
                data.addColumn('number', 'Група');
                data.addColumn('number', 'Брой');;
                data.addRows([
                    <?php
                    foreach ($fhfDataPoints as $key => $row):
                        echo "['" . $row['major'] . "','" . $row['degree'] . "'," . $row['year'] . "," . $row['stream'] . "," . $row['group_number'] . "," . $row['cnt'] . "],";
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
                <th>Степен</th>
                <th>Курс</th>
                <th>Поток</th>
                <th>Група</th>
                <th>Брой</th>
            </tr>

            <?php foreach ($fzf as $key => $row): ?>
                <tr>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['degree']; ?></td>
                    <td><?php echo $row['years']; ?></td>
                    <td><?php echo $row['stream']; ?></td>
                    <td><?php echo $row['group_number']; ?></td>
                    <td><?php echo $row['cnt']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
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
                data.addColumn('string', 'Степен');
                data.addColumn('number', 'Курс');
                data.addColumn('number', 'Поток');
                data.addColumn('number', 'Група');
                data.addColumn('number', 'Брой');
                data.addRows([
                    <?php
                    foreach ($fzfDataPoints as $key => $row):
                        echo "['" . $row['major'] . "','" . $row['degree'] . "'," . $row['year'] . "," . $row['stream'] . "," . $row['group_number'] . "," . $row['cnt'] . "],";
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
                <th>Степен</th>
                <th>Курс</th>
                <th>Поток</th>
                <th>Група</th>
                <th>Брой</th>
            </tr>

            <?php foreach ($bl2 as $key => $row): ?>
                <tr>
                    <td><?php echo $row['major']; ?></td>
                    <td><?php echo $row['degree']; ?></td>
                    <td><?php echo $row['years']; ?></td>
                    <td><?php echo $row['stream']; ?></td>
                    <td><?php echo $row['group_number']; ?></td>
                    <td><?php echo $row['cnt']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
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
                data.addColumn('string', 'Степен');
                data.addColumn('number', 'Курс');
                data.addColumn('number', 'Поток');
                data.addColumn('number', 'Група');
                data.addColumn('number', 'Брой');
                data.addRows([
                    <?php
                    foreach ($blockDataPoints as $key => $row):
                        echo "['" . $row['major'] . "','" . $row['degree'] . "'," . $row['year'] . "," . $row['stream'] . "," . $row['group_number'] . "," . $row['cnt'] . "],";
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
