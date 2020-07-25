<div class="tab-container">
    <button class="tab tab-active" id="fmi-tab" onclick="showFMIinfo()">ФМИ</button>
    <button class="tab" id="fzf-tab" onclick="showFHFinfo()">ФХФ</button>
    <button class="tab" id="fhf-tab" onclick="showFZFinfo()">ФЗФ</button>
    <button class="tab" id="bl2-tab" onclick="showBlok2info()">Блок 2</button>
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
    $fmi_keys = array();
    $fmi_values = array();
    $fhf_keys = array();
    $fhf_values = array();
    $fzf_keys = array();
    $fzf_values = array();
    $block_keys = array();
    $block_values = array();
    $fmi = $db->getMajorsInFMI();
    $fzf = $db->getMajorsInFZF();
    $fhf = $db->getMajorsInFHF();
    $bl2 = $db->getMajorsInBlock2();
    //tablicite da gi ostavim 4e ina4e nqma kvo da se izteglq?
    ?>
    <div id="fmi-container">
        <h2>ФМИ</h2>
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
                array_push($fmi_keys, $row['major']);
                array_push($fmi_values, $row['cnt']);
            endforeach;
            $fmiDataPoints = array_combine($fmi_keys, $fmi_values);
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
                    foreach ($fmiDataPoints as $key => $row):
                        echo "['" . $key . "'," . $row . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('fmi'));
                chart.draw(data, options);
            }
        </script>
        <div class="chart-container bar-chart" id="fmi"></div>
    </div>

    <div id="fhf-container" hidden>
        <h2>ФХФ</h2>
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
                array_push($fhf_keys, $row['major']);
                array_push($fhf_values, $row['cnt']);
            endforeach;
            $fhfDataPoints = array_combine($fmi_keys, $fmi_values);
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
                    foreach ($fhfDataPoints as $key => $row):
                        echo "['" . $key . "'," . $row . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('fhf'));
                chart.draw(data, options);
            }
        </script>
        <div class="chart-container bar-chart" id="fhf"></div>
    </div>

    <div id="fzf-container" hidden>
        <h2>ФЗФ</h2>
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
                array_push($fzf_keys, $row['major']);
                array_push($fzf_values, $row['cnt']);
            endforeach;
            $fzfDataPoints = array_combine($fzf_keys, $fzf_values);
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
                    foreach ($fzfDataPoints as $key => $row):
                        echo "['" . $key . "'," . $row . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('fzf'));
                chart.draw(data, options);
            }
        </script>
        <div class="chart-container bar-chart" id="fzf"></div>
    </div>

    <div id="block-container" hidden>
        <h2>Блок 2</h2>
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
                array_push($block_keys, $row['major']);
                array_push($block_values, $row['cnt']);
            endforeach;
            $blockDataPoints = array_combine($block_keys, $block_values);
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
                    foreach ($blockDataPoints as $key => $row):
                        echo "['" . $key . "'," . $row . "],";
                    endforeach;
                    ?>
                ]);
                var chart = new google.visualization.ColumnChart(document.getElementById('block'));
                chart.draw(data, options);
            }
        </script>
        <div class="chart-container bar-chart" id="block"></div>
    </div>
</div>
