<div class="tab-container">
    <button class="tab tab-active" id="table-tab" onclick="showTable('majors')">Таблица</button>
    <button class="tab" id="chart-tab" onclick="showChart('majors')">Графика</button>
</div>
<div class="table-container" id="table-container">
    <h2 class="table-name">Брой на студенти по специалност</h2>
    <div class="download-form">
        <label>Изтегли като: </label>
        <button class="download-button" id="download" value="csv"
                onclick="downloadCsv('major')">.csv
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
            <th>Специалност</th>
            <th>Специалност - пълно наименование</th>
            <th>Степен</th>
        </tr>

        <?php
        foreach ($tableData as $key => $row): ?>
            <tr>
                <td><?php echo $row['count']; ?></td>
                <td><?php echo $row['major']; ?></td>
                <td><?php echo $row['major_full_name']; ?></td>
                <td><?php echo $row['degree']; ?></td>
            </tr>
            <?php
            $percentage = round($row['count'] * 100 / $size, 2);
            array_push($keys, $row['major']);
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
                title: 'Специалности',
                'width': 600,
                'height': 300
            };
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Major');
            data.addColumn('number', 'Percentage');
            data.addRows([
                <?php
                foreach ($dataPoints as $key => $row):
                    echo "['" . $key . "'," . $row . "],";
                endforeach;
                ?>
            ]);
            var chart = new google.visualization.PieChart(document.getElementById('majors'));
            chart.draw(data, options);
        }
    </script>
</div>
<div class="chart-container" id="majors" hidden></div>
