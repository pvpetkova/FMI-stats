<h2 class="table-name">Брой на студенти по потоци</h2>
<div class="download-form">
    <label>Изтегли като: </label>
    <button class="download-button" id="download" value="csv"
            onclick="downloadCsv('potoci')">.csv
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
        <th>Поток</th>
        <th>Специалност</th>
        <th>Специалност - пълно наименование</th>
        <th>Степен</th>
    </tr>

    <?php foreach ($tableData as $key => $row): ?>
        <tr>
            <td><?php echo $row['count']; ?></td>
            <td><?php echo $row['stream']; ?></td>
            <td><?php echo $row['major']; ?></td>
            <td><?php echo $row['major_full_name']; ?></td>
            <td><?php echo $row['degree']; ?></td>
        </tr>
        <?php
        $percentage = round($row['count'] * 100 / $size, 2);
        array_push($keys, $row['stream']);
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
            title: 'Потоци',
            'width': 600,
            'height': 300
        };
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Stream');
        data.addColumn('number', 'Percentage');
        data.addRows([
            <?php
            foreach ($dataPoints as $key => $row):
                echo "['" . $key . "'," . $row . "],";
            endforeach;
            ?>
        ]);
        var chart = new google.visualization.PieChart(document.getElementById('potoci'));
        chart.draw(data, options);
    }
</script>
<div class="chartContainer" id="potoci" style="margin-left: 35%"></div>
