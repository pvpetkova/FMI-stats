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
<div class="chart-container" id="buildings" hidden></div>