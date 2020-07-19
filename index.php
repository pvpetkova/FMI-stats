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
        }
        if (isset($_GET["json"]) && $_GET["json"] == 'true') {
            echo json_encode($tableData);
            return;
        }
    }
} else {
    $nameError = "Моля въведете име.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
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
            <add name="Access-Control-Allow-Origin" value="*" />
        </customHeaders>
    </httpProtocol>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .hero-image {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url("./styles/assets/Sofia_University_-_FMI_1.jpg");
            height: 350px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            margin-bottom: 30px;
        }

        .hero-text {
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            line-height: 0.95;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: 500;
        }

        h1 {
            font-family: 'Roboto Slab', serif;
            font-weight: 500;
        }

        h2, h3, h4, h5 {
            font-family: 'Roboto Slab', serif;
            font-weight: 300;
        }

        table {
            border-collapse: collapse;
            width: 60%;
            margin: 0 auto;
            border: 1px solid #959595;
            border-radius: 50px;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #528b50;
            color: white;
        }

        .table-name {
            text-align: center;
        }

        .content {
            width: 100%;
            height: 100%;
        }

        .dropdown {
            display: block;
            text-align: center;
            margin-bottom: 25px;
        }

        input, select {
            font-size: inherit;
        }

        select {
            padding: 8px 5px 8px 15px;
            width: 500px;
            margin: 10px;
            font-family: inherit;
            border: 1px solid #a6a6a6;
            border-radius: 20px;
        }

        select:invalid {
            color: grey;
        }

        input[type=submit] {
            border-radius: 20px;
            border: none;
            display: inline-block;
            padding: 10px 25px;
            color: #ffffff;
            background-color: #528b50;
            text-align: center;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #326532;
            color: white;
            transition: background-color 350ms ease;
        }

        .footer {
            width: 100%;
            margin-top: 50px;
            text-align: center;
            line-height: 0.5;
            font-size: 14px;
            padding: 15px 0 15px 0;
            background-color: #f2f2f2;
        }

    </style>
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
                    <option value="major">По специалност</option>
                    <option value="degree">По степен</option>
                    <option value="year">По курс</option>
                    <option value="group">По група</option>
                    <option value="potok">По поток</option>
                </select>
                <input id="submit" name="submit" type="submit" value="Групирай!">
            </form>
        </div>

        <?php if ($loadAll):
            $table = $db->selectAll();
            include 'allStudents.php'; endif; ?>

        <?php if ($loadMajors): ?>
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
            <div class="chartContainer" id="majors" style="margin-left: 35%"></div>
        <?php endif; ?>

        <?php if ($loadGroups): ?>
            <h2 class="table-name">Брой на студенти по групи</h2>
            <div class="download-form">
                <label>Изтегли като: </label>
                <button class="download-button" id="download" value="csv"
                        onclick="downloadCsv('group')">.csv
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
                    <th>Група</th>
                    <th>Специалност</th>
                    <th>Специалност - пълно наименование</th>
                    <th>Степен</th>
                </tr>

                <?php foreach ($tableData as $key => $row): ?>
                    <tr>
                        <td><?php echo $row['count']; ?></td>
                        <td><?php echo $row['group_number']; ?></td>
                        <td><?php echo $row['major']; ?></td>
                        <td><?php echo $row['major_full_name']; ?></td>
                        <td><?php echo $row['degree']; ?></td>
                    </tr>
                    <?php
                    $percentage = round($row['count'] * 100 / $number, 2);
                    array_push($keys, $row['group_number']);
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
                        title: 'Групи',
                        'width': 600,
                        'height': 300,
                    };
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Groups');
                    data.addColumn('number', 'Percentage');
                    data.addRows([
                        <?php
                        foreach ($dataPoints as $key => $row):
                            echo "['" . $key . "'," . $row . "],";
                        endforeach;
                        ?>
                    ]);
                    var chart = new google.visualization.PieChart(document.getElementById('groups'));
                    chart.draw(data, options);
                }
            </script>
            <div class="chartContainer" id="groups" style="margin-left: 35%"></div>
        <?php endif; ?>

        <?php if ($loadPotoci): ?>
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
                    $percentage = round($row['count'] * 100 / $number, 2);
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
        <?php endif; ?>

        <?php if ($loadYears): ?>
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
                    $percentage = round($row['count'] * 100 / $number, 2);
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
        <?php endif; ?>

        <?php if ($loadDegrees): ?>
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
            <table style="width: 300px">
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
                    $percentage = round($row['count'] * 100 / $number, 2);
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
                    console.log(data);
                    var chart = new google.visualization.PieChart(document.getElementById('degrees'));
                    chart.draw(data, options);
                }
            </script>
            <div class="chartContainer" id="degrees" style="margin-left: 35%"></div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>Пламена Петкова & Ина Георгиева • Проект по Уеб Технологии, СУ - ФМИ, 2020</p>
    </div>

</main>
</body>
</html>
