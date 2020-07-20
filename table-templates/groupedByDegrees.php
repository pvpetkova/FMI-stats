<div class="tab-container">
    <button class="tab tab-active" id="table-tab" onclick="showTable('degrees')">Таблица</button>
    <button class="tab" id="chart-tab" onclick="showChart('degrees')">Графика</button>
</div>
<div class="table-container" id="table-container">
    <h2 class="table-name">Брой на студенти по степен</h2>
    <div class="download-form">
        <label>Изтегли като: </label>
        <button class="download-button" id="download" value="csv"
                onclick="downloadCsv('degree')">.csv
        </button>
    </div>
    <?php
    $size = count($tableData);
    $keys = array();
    $values = array();
    ?>
    <table>
        <tr>
            <th>Брой</th>
            <th>Степен</th>
        </tr>

        <?php foreach ($tableData as $key => $row): ?>
            <tr>
                <td><?php echo $row['count']; ?></td>
                <td><?php echo $row['degree']; ?></td>
            </tr>
            <?php
            $percentage = round($row['count'] * 100 / $size, 2);
            array_push($keys, $row['degree']);
            array_push($values, $percentage);
        endforeach;
        $dataPoints = array_combine($keys, $values);
        ?>
    </table>
    <script>
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var options = {
                title: 'Степени',
                'width': 600,
                'height': 300
            };
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Degree');
            data.addColumn('number', 'Percentage');
            data.addRows([
                <?php
                foreach ($dataPoints as $key => $row):
                    echo "['" . $key . "'," . $row . "],";
                endforeach;
                ?>
            ]);
            var chart = new google.visualization.PieChart(document.getElementById('degrees'));
            chart.draw(data, options);
        }
    </script>
</div>
<div class="chart-container" id="degrees" hidden></div>
