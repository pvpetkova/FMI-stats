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

    }
} else {
    $nameError = "Моля въведете име.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ФМИ - натоварване на сградата</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;500&family=Roboto:wght@300&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&family=Roboto:wght@300&display=swap"
          rel="stylesheet">
    <script type="text/javascript" src="script/script.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
                    <!--TODO kak e potok?-->
                    <option value="potok">По поток</option>
                </select>
                <input id="submit" name="submit" type="submit" value="Групирай!">
            </form>
        </div>

        <?php if ($loadAll): ?>
            <div class="table-container">
                <h2 class="table-name">Списък на всички студенти</h2>
                <div class="download-form">
                    <label>Изтегли като: </label>
                    <button class="download-button" id="download" value="csv"
                            onclick="downloadCsv()">.csv
                    </button>
                </div>
                <table>
                    <tr>
                        <th id="fn" scope="col">ФН</th>
                        <th id="degree" scope="col">Степен</th>
                        <th id="major" scope="col">Специалност</th>
                        <th id="major_full_name" scope="col">Специалност - пълно наименование</th>
                        <th id="year" scope="col">Курс</th>
                        <th id="stream" scope="col">Поток</th>
                        <th id="group_number" scope="col">Група</th>
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
        <?php endif; ?>

        <?php if ($loadMajors): ?>
        <div class="table-container">
            <h2 class="table-name">Брой на студенти по специалност</h2>
            <div class="download-form">
                <label>Изтегли като: </label>
                <button class="download-button" id="download" value="csv"
                        onclick="downloadCsv('major')">.csv
                </button>
            </div>
            <?php
            $number = count($tableData);
            $dataPoints = array();
            ?>
            <table>
                <tr>
                    <th scope="col" id="count">Брой</th>
                    <th scope="col">Специалност</th>
                    <th scope="col">Специалност - пълно наименование</th>
                    <th scope="col">Степен</th>
                </tr>

                <?php foreach ($tableData as $key => $row): ?>
                    <tr>
                        <td><?php echo $row['count']; ?></td>
                        <td><?php echo $row['major']; ?></td>
                        <td><?php echo $row['major_full_name']; ?></td>
                        <td><?php echo $row['degree']; ?></td>
                    </tr>
                    <?php
                    $percentage = ($row['count'] / $number);
                    array_push($dataPoints, $percentage);
                endforeach;
                ?>
            </table>
            <script>
                window.onload = function () {
                    var chart = new CanvasJS.Chart("majors", {
                        animationEnabled: true,
                        data: [{
                            type: "pie",
                            yValueFormatString: "#,##0.00\"%\"",
                            //indexLabel: "{$row['major']} {percentage}",
                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();
                }
            </script>
            <div class="chartContainer" id="majors"></div>

            <?php endif; ?>

            <?php if ($loadGroups): ?>
                <div class="table-container">
                    <h2 class="table-name">Брой на студенти по групи</h2>
                    <div class="download-form">
                        <label>Изтегли като: </label>
                        <button class="download-button" id="download" value="csv"
                                onclick="downloadCsv()">.csv
                        </button>
                    </div>
                    <?php
                    $number = count($tableData);
                    $dataPoints = array();
                    ?>
                    <table>
                        <tr>
                            <th scope="col">Брой</th>
                            <th scope="col">Група</th>
                            <th scope="col">Специалност</th>
                            <th scope="col">Специалност - пълно наименование</th>
                            <th scope="col">Степен</th>
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
                            $percentage = ($row['count'] / $number);
                            array_push($dataPoints, $percentage);
                        endforeach;
                        ?>
                    </table>
                    <script>
                        window.onload = function () {
                            var chart = new CanvasJS.Chart("groups", {
                                animationEnabled: true,
                                data: [{
                                    type: "pie",
                                    yValueFormatString: "#,##0.00\"%\"",
                                    //indexLabel: "{label} ({y})",
                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();
                        }
                    </script>
                    <div class="chartContainer" id="groups"></div>
                </div>
            <?php endif; ?>

            <?php if ($loadPotoci): ?>
                <div class="table-container">
                    <h2 class="table-name">Брой на студенти по потоци</h2>
                    <div class="download-form">
                        <label>Изтегли като: </label>
                        <button class="download-button" id="download" value="csv"
                                onclick="downloadCsv()">.csv
                        </button>
                    </div>
                    <?php
                    $number = count($tableData);
                    $dataPoints = array();
                    ?>
                    <table>
                        <tr>
                            <th scope="col">Брой</th>
                            <th scope="col">Поток</th>
                            <th scope="col">Специалност</th>
                            <th scope="col">Специалност - пълно наименование</th>
                            <th scope="col">Степен</th>
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
                            $percentage = ($row['count'] / $number);
                            array_push($dataPoints, $percentage);
                        endforeach;
                        ?>
                    </table>
                    <script>
                        window.onload = function () {
                            var chart = new CanvasJS.Chart("potoci", {
                                animationEnabled: true,
                                data: [{
                                    type: "pie",
                                    yValueFormatString: "#,##0.00\"%\"",
                                    //indexLabel: "{label} ({y})",
                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();
                        }
                    </script>
                    <div class="chartContainer" id="potoci"></div>
                </div>
            <?php endif; ?>

            <?php if ($loadYears): ?>
                <div class="table-container">
                    <h2 class="table-name">Брой на студенти по курсове</h2>
                    <div class="download-form">
                        <label>Изтегли като: </label>
                        <button class="download-button" id="download" value="csv"
                                onclick="downloadCsv()">.csv
                        </button>
                    </div>
                    <?php
                    $number = count($tableData);
                    $dataPoints = array();
                    ?>
                    <table>
                        <tr>
                            <th scope="col">Брой</th>
                            <th scope="col">Курс</th>
                            <th scope="col">Специалност</th>
                            <th scope="col">Специалност - пълно наименование</th>
                            <th scope="col">Степен</th>
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
                            $percentage = ($row['count'] / $number);
                            array_push($dataPoints, $percentage);
                        endforeach;
                        ?>
                    </table>
                    <script>
                        window.onload = function () {
                            var chart = new CanvasJS.Chart("years", {
                                animationEnabled: true,
                                data: [{
                                    type: "pie",
                                    yValueFormatString: "#,##0.00\"%\"",
                                    //indexLabel: "{label} ({y})",
                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();
                        }
                    </script>
                    <div class="chartContainer" id="years"></div>
                </div>
            <?php endif; ?>

            <?php if ($loadDegrees): ?>
                <div class="table-container">
                    <h2 class="table-name">Брой на студенти по степен</h2>
                    <div class="download-form">
                        <label>Изтегли като: </label>
                        <button class="download-button" id="download" value="csv"
                                onclick="downloadCsv()">.csv
                        </button>
                    </div>
                    <?php $dataPoints = array(); ?>
                    <table>
                        <tr>
                            <th scope="col">Брой</th>
                            <th scope="col"></th>
                            <th scope="col">Степен</th>
                        </tr>

                        <?php foreach ($tableData as $key => $row): ?>
                            <tr>
                                <td><?php echo $row['count']; ?></td>
                                <td></td>
                                <td><?php echo $row['degree']; ?></td>
                            </tr>
                            <?php
                            array_push($dataPoints, $row['count']);
                        endforeach;
                        ?>
                    </table>
                    <script>
                        window.onload = function () {

                            var chart = new CanvasJS.Chart("degrees", {
                                animationEnabled: true,
                                theme: "light2",
                                data: [{
                                    type: "column",
                                    yValueFormatString: "#,##0.## tonnes",
                                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();
                        }
                    </script>
                    <div class="chartContainer" id="degrees"></div>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>Пламена Петкова & Ина Георгиева • Проект по Уеб Технологии, СУ - ФМИ, 2020</p>
        </div>

</main>
</body>
</html>
