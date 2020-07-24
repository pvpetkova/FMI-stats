<div class="tab-container">
    <button class="tab tab-active" id="table-tab" onclick="showTable('degrees')">Таблица</button>
    <button class="tab" id="chart-tab" onclick="showChart('degrees')">Графика</button>
</div>
<div class="table-container" id="table-container">
    <h2 class="table-name"></h2>
    <div class="download-form">
        <label>Изтегли като: </label>
        <button class="download-button" id="download" value="csv"
                onclick="downloadCsv('degree')">.csv
        </button>
    </div>
    <?php
    $buildings=$db->getAllBuildings();
    $people=array();
    $buildings=array();
    $percentages = array();
    array_push($people,$db->getPeopleInFMI());
    array_push($people,$db->getPeopleInFHF());
    array_push($people,$db->getPeopleInFZF());
    array_push($people,$db->getPeopleInBlock2());
    ?>
    <table>
        <tr>
            <th>Сграда</th>
            <th>Капацитет</th>
            <th>Брой студенти</th>
        </tr>

        <?php $counter = 0;
        foreach ($buildings as $key => $row): ?>
            <tr>
                <td><?php echo $row['building']; ?></td>
                <td><?php echo $row['capacity']; ?></td>
                <td><?php echo $people[$counter];?></td>
            </tr>
            <?php
            $counter++;
        endforeach;
        $dataPoints = array_combine($buildings, $people); //nz toq combine dali moje da bachka taka
        print_r($dataPoints);
        ?>
    </table>
</div>
<div class="chart-container" id="degrees" hidden></div>