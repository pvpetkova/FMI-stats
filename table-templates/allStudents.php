<div class="table-container">
    <h2 class="table-name">Списък на всички студенти</h2>
    <table>
        <tr>
            <th>ФН</th>
            <th>Степен</th>
            <th>Специалност</th>
            <th>Специалност - пълно наименование</th>
            <th>Курс</th>
            <th>Поток</th>
            <th>Група</th>
        </tr>

        <?php foreach ($tableData as $key => $row): ?>
            <tr>
                <td><?php echo $row['fn']; ?></td>
                <td><?php echo $row['degree']; ?></td>
                <td><?php echo $row['major']; ?></td>
                <td><?php echo $row['major_full_name']; ?></td>
                <td><?php echo $row['year']; ?></td>
                <td><?php echo $row['stream']; ?></td>
                <td><?php echo $row['group_number']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>