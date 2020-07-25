<?php
include('./db/DBConnector.php');

$loadBuildings = true;
$loadMajors = $loadDegrees = $loadYears =
$loadGroups = $loadPotoci = $loadAll = false;
try {
    $db = new DBConnector();
} catch (Exception $e) {
    $connectionError = "Неуспешно свързване с базата. Моля опитайте отново.";
}
$tableData = [
    $db->getPeopleInFMI(),
    $db->getPeopleInFHF(),
    $db->getPeopleInFZF(),
    $db->getPeopleInBl2()
];
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["grouping"])) {
        $loadBuildings = false;
        switch ($_GET["grouping"]) {
            case 'showAll':
                $tableData = $db->selectAll();
                $loadAll = true;
                break;
            case 'major':
                $tableData = $db->groupByMajor();
                $loadMajors = true;
                break;
            case 'degree':
                $tableData = $db->groupByDegrees();
                $loadDegrees = true;
                break;
            case 'year':
                $tableData = $db->groupByYears();
                $loadYears = true;
                break;
            case 'group':
                $tableData = $db->groupByGroups();
                $loadGroups = true;
                break;
            case 'potok':
                $tableData = $db->groupByPotoci();
                $loadPotoci = true;
                break;
            case 'buildings':
                $tableData = [
                    $db->getPeopleInFMI(),
                    $db->getPeopleInFHF(),
                    $db->getPeopleInFZF(),
                    $db->getPeopleInBl2()
                ];
                $loadBuildings = true;
                break;
        }
        if (isset($_GET["json"]) && $_GET["json"] == 'true') {
            echo json_encode($tableData);
            return;
        }
    } else {
        $tableData = [
            $db->getPeopleInFMI(),
            $db->getPeopleInFHF(),
            $db->getPeopleInFZF(),
            $db->getPeopleInBl2()
        ];
        $loadBuildings = true;
    }
} else {
    $nameError = "Моля въведете име.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Статистики за ФМИ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;500&family=Roboto:wght@300&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&family=Roboto:wght@300&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <script type="text/javascript" src="script/script.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <httpProtocol>
        <customHeaders>
            <add name="Access-Control-Allow-Origin" value="*"/>
        </customHeaders>
    </httpProtocol>
</head>
<body>
<main>

    <div class="hero-image">
        <div class="hero-text">
            <a href="index.php">
                <h1 style="font-size: 50px">Колко са натоварени сградите на ФМИ?</h1></a>
            <p>PSA: Тези данни са измислени.</p>
        </div>
    </div>

    <div class="content">
        <div class="dropdown">
            <form method="GET"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                  enctype='multipart/form-data'>
                <label for="grouping">Изберете критерий за групиране:<br></label>
                <select id="grouping" name="grouping" autocomplete="off">
                    <option disabled hidden selected value="">Моля изберете...</option>
                    <option value="showAll">Списък на всички студенти</option>
                    <option value="major">По специалност</option>
                    <option value="degree">По степен</option>
                    <option value="year">По курс</option>
                    <option value="group">По група</option>
                    <option value="potok">По поток</option>
                </select>
                <input id="submit" name="submit" type="submit" value="Групирай!">
                <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                      enctype='multipart/form-data'>
                    <input type="submit" value="Покажи всички" style="background-color: #a6a6a6">
                </form>
            </form>

        </div>

        <?php if ($loadBuildings):
            $tableData;
            include_once 'table-templates/buildings.php'; endif; ?>

        <?php if ($loadAll):
            $table = $db->selectAll();
            include 'table-templates/allStudents.php'; endif; ?>

        <?php if ($loadMajors):
            include_once 'table-templates/buildingsByMajor.php'; endif; ?>

        <?php if ($loadGroups):
            $tableData;
            include_once 'table-templates/buildingsByGroups.php'; endif; ?>

        <?php if ($loadPotoci):
            $tableData;
            include_once 'table-templates/buildingsByPotoci.php'; endif; ?>

        <?php if ($loadYears):
            $tableData;
            include_once 'table-templates/buildingsByYears.php'; endif; ?>

        <?php if ($loadDegrees):
            $tableData;
            include_once 'table-templates/buildingsByDegree.php'; endif; ?>
    </div>

    <div class="footer">
        <p>Пламена Петкова & Ина Георгиева • Проект по Уеб Технологии, СУ - ФМИ, 2020</p>
    </div>
</main>
</body>
</html>
