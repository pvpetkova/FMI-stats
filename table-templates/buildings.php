<div class="tab-container">
    <button class="tab tab-active" id="table-tab" onclick="showTable('buildings')">Таблица</button>
    <button class="tab" id="chart-tab" onclick="showChart('buildings')">Графика</button>
</div>
<div class="table-container" id="table-container">
    <h2 class="table-name">Сгради и брой студенти в тях</h2>
    <div class="download-form">
        <label>Изтегли като: </label>
        <button class="download-button" id="download" value="csv"
                onclick="downloadCsv('buildings')">.csv
        </button>
    </div>

    <script>
        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Сграда');
            data.addColumn('number', 'Капацитет');
            data.addColumn('number', 'Заетост');

            data.addRows([
                <?php
                for ($i = 0; $i < 4; $i++):
                    echo "['" . $tableData[$i][0]['building'] . "'," . $tableData[$i][0]['capacity'] . ", " . $tableData[$i][0]['sum'] .  "],";
                endfor;
                ?>
            ]);

            var options = {
                chart: {
                    title: ''
                },
                width: 900,
                height: 350

            };
            var chart = new google.charts.Line(document.getElementById('buildings'));
            chart.draw(data, google.charts.Line.convertOptions(options));
        }
    </script>
    <table>
        <tr>
            <th>Сграда</th>
            <th>Капацитет</th>
            <th>Брой студенти</th>
        </tr>
        <?php for ($i = 0; $i < 4; $i++): ?>
            <tr>
                <td><?php echo $tableData[$i][0]['building']; ?></td>
                <td><?php echo $tableData[$i][0]['capacity']; ?></td>
                <td><?php echo $tableData[$i][0]['sum']; ?></td>
            </tr>
        <?php endfor; ?>
    </table>
</div>
<div class="chart-container line-chart" id="buildings" style="height: 350px" hidden></div>