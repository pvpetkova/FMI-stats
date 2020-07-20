<h2 class="table-name">Брой на студенти по курсове</h2>
<div class="download-form">
    <label>Изтегли като: </label>
    <button class="download-button" id="download" value="csv"
            onclick="downloadCsv('year')">.csv
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
        <th>Курс</th>
        <th>Специалност</th>
        <th>Специалност - пълно наименование</th>
        <th>Степен</th>
    </tr>

    <?php foreach ($tableData as $key => $row): ?>
        <tr>
            <td><?php echo $row['count']; ?></td>
            <td><?php echo $row['year']; ?></td>
            <td><?php echo $row['major']; ?></td>
            <td><?php echo $row['major_full_name']; ?></td>
            <td><?php echo $row['degree']; ?></td>
        </tr>
        <?php
        $percentage = round($row['count'] * 100 / $size, 2);
        array_push($keys, $row['year']);
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
            title: 'Курсове',
            'width': 600,
            'height': 300
        };
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Years');
        data.addColumn('number', 'Percentage');
        data.addRows([
            <?php
            foreach ($dataPoints as $key => $row):
                echo "['" . $key . "'," . $row . "],";
            endforeach;
            ?>
        ]);
        var chart = new google.visualization.PieChart(document.getElementById('years'));
        chart.draw(data, options);
    }
</script>
<div class="chartContainer" id="years" style="margin-left: 35%"></div>
