<?php

include('./db/DBConnector.php');

$loadAll = true;
$loadMajors = $loadDegrees = $loadYears = $loadGroups = $loadPotoci = false;
try {
    $db = new DBConnector();
} catch (Exception $e) {
    $connectionError = "Неуспешно свързване с базата. Моля опитайте отново.";
}
$tableData = $db->selectAll();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["grouping"])) {
        $loadAll = false;
        switch ($_GET["grouping"]) {
            case 'major':
                $tableData = $db->groupByMajor();
                echo json_encode($tableData);
                $loadMajors = true;
                break;
            case 'degree':
                $tableData = $db->groupByDegrees();
                echo json_encode($tableData);
                $loadDegrees = true;
                break;
            case 'year':
                echo json_encode($db->groupByYears());
                break;
            case 'group':
                $tableData = $db->groupByGroups();
                echo json_encode($tableData);
                $loadGroups = true;
                break;
            case 'potok':
                $tableData = $db->groupByPotoci();
                echo json_encode($tableData);
                $loadPotoci = true;
                break;
        }
    } else {
        echo json_encode($db->selectAll());
    }
}
