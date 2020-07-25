<?php

class DBConnector
{
    private $connection;

    public function __construct()
    {
        $config = json_decode(file_get_contents(__DIR__ . "/../config.json"), true);
        $host = $config['dbServer'];
        $port = $config['dbPort'];
        $db = $config['dbName'];
        $user = $config['dbUser'];
        $password = $config['dbPassword'];
        $charset = $config['dbCharset'];

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        try {
            $this->connection = new PDO($dsn, $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function selectAll()
    {
        try {
            $sql = "SELECT * FROM `students-fmi`";
            return $this->executeSelect($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
            return "Не можахме да извлечем информация.";
        }
    }

    public function groupByGroups()
    {
        $sql = "SELECT COUNT(group_number) AS count, group_number, major, major_full_name, degree, year, stream 
                            FROM `students-fmi`
                            GROUP BY major, stream, year, group_number
                            ORDER BY major, year, stream, group_number DESC";
        return $this->executeSelect($sql);
    }

    public function groupByPotoci()
    {
        $sql = "SELECT COUNT(stream) AS count, stream, major, major_full_name, degree
                            FROM `students-fmi`
                            GROUP BY major, stream
                            ORDER BY COUNT(stream) DESC";
        return $this->executeSelect($sql);
    }

    public function groupByYears()
    {
        $sql = "SELECT COUNT(*) AS count, year, major, major_full_name, degree
                            FROM `students-fmi`
                            GROUP BY major, year
                            ORDER BY count DESC";
        return $this->executeSelect($sql);
    }

    public function groupByMajor()
    {
        $sql = "SELECT COUNT(major) as count, major, major_full_name, degree
                    FROM `students-fmi`
                    GROUP BY major
                    ORDER by COUNT(major) DESC";
        return $this->executeSelect($sql);
    }

    public function groupByDegrees()
    {
        $sql = "SELECT COUNT(degree) as count, degree
                        FROM `students-fmi`
                        GROUP BY degree
                        ORDER by COUNT(degree) DESC";
        return $this->executeSelect($sql);
    }

    public function getBuildingsCapacity()
    {
        try {
            $sql = "SELECT * FROM `capacity`";
            return $this->executeSelect($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
            return "Не можахме да извлечем информация.";
        }
    }

    public function getAllBuildings()
    {
        try {
            $sql = "SELECT * FROM `distribution`";
            return $this->executeSelect($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
            return "Не можахме да извлечем информация.";
        }
    }

    public function getPeopleInFMI()
    {
        $sql = "SELECT SUM(c) as sum, building, capacity  FROM
            (SELECT * FROM `distribution`
                        WHERE fmi != 0) a
                        JOIN
                        (SELECT COUNT(group_number) AS c, group_number, major, major_full_name, degree, year, stream, building, capacity
                            FROM `students-fmi`, `capacity` cap
                            WHERE building = 'ФМИ'
                            GROUP BY major, stream, year, group_number
                            ORDER BY major, year, stream, group_number DESC) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number";
        return $this->executeSelect($sql);
    }

    public function getPeopleInFHF()
    {
        $sql = "SELECT SUM(c) as sum, building, capacity  FROM
            (SELECT * FROM `distribution`
                        WHERE fhf != 0) a
                        JOIN
                        (SELECT COUNT(group_number) AS c, group_number, major, major_full_name, degree, year, stream, building, capacity
                            FROM `students-fmi`, `capacity` cap
                            WHERE building = 'ФХФ'
                            GROUP BY major, stream, year, group_number
                            ORDER BY major, year, stream, group_number DESC) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number";
        return $this->executeSelect($sql);
    }

    public function getPeopleInFZF()
    {
        $sql = "SELECT SUM(c) as sum, building, capacity  FROM
            (SELECT * FROM `distribution`
                        WHERE fzf != 0) a
                        JOIN
                        (SELECT COUNT(group_number) AS c, group_number, major, major_full_name, degree, year, stream, building, capacity
                            FROM `students-fmi`, `capacity` cap
                            WHERE building = 'ФЗФ'
                            GROUP BY major, stream, year, group_number
                            ORDER BY major, year, stream, group_number DESC) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number";
        return $this->executeSelect($sql);
    }

    public function getPeopleInBl2()
    {
        $sql = "SELECT SUM(c) as sum, building, capacity  FROM
            (SELECT * FROM `distribution`
                        WHERE block != 0) a
                        JOIN
                        (SELECT COUNT(group_number) AS c, group_number, major, major_full_name, degree, year, stream, building, capacity
                            FROM `students-fmi`, `capacity` cap
                            WHERE building = 'Блок 2'
                            GROUP BY major, stream, year, group_number
                            ORDER BY major, year, stream, group_number DESC) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number";
        return $this->executeSelect($sql);
    }


    public function getMajorsInFMI()
    {
        $sql = "SELECT a.major, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fmi != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major
            ORDER BY cnt DESC";

        return $this->executeSelect($sql);
    }

    public function getMajorsInFHF()
    {
        $sql = "SELECT a.major, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fhf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major
            ORDER BY cnt DESC";

        return $this->executeSelect($sql);
    }

    public function getMajorsInFZF()
    {
        $sql = "SELECT a.major, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fzf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major
            ORDER BY cnt DESC";

        return $this->executeSelect($sql);
    }

    public function getMajorsInBl2()
    {
        $sql = "SELECT a.major, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE block != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major
            ORDER BY cnt DESC";

        return $this->executeSelect($sql);
    }

    public function getGroupsInFMI()
    {
        $sql = "SELECT a.major, a.degree, a.years, a.stream, a.group_number, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fmi != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major, a.degree, a.years, a.stream, a.group_number
            ORDER BY major, years, stream, group_number DESC";

        return $this->executeSelect($sql);
    }

    public function getGroupsInFHF()
    {
        $sql = "SELECT a.major, a.degree, a.years, a.stream, a.group_number, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fhf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major, a.degree, a.years, a.stream, a.group_number
            ORDER BY major, years, stream, group_number DESC";

        return $this->executeSelect($sql);
    }

    public function getGroupsInFZF()
    {
        $sql = "SELECT a.major, a.degree, a.years, a.stream, a.group_number, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fzf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major, a.degree, a.years, a.stream, a.group_number
            ORDER BY major, years, stream, group_number DESC";

        return $this->executeSelect($sql);
    }

    public function getGroupsInBl2()
    {
        $sql = "SELECT a.major, a.degree, a.years, a.stream, a.group_number, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE block != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major, a.degree, a.years, a.stream, a.group_number
            ORDER BY major, years, stream, group_number DESC";

        return $this->executeSelect($sql);
    }

    public function getDegreesInFMI()
    {
        $sql = "SELECT a.major, a.degree, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fmi != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major, a.degree
            ORDER BY cnt DESC";

        return $this->executeSelect($sql);
    }

    public function getDegreesInFHF()
    {
        $sql = "SELECT a.major, a.degree, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fhf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major, a.degree
            ORDER BY cnt DESC";

        return $this->executeSelect($sql);
    }

    public function getDegreesInFZF()
    {
        $sql = "SELECT a.major, a.degree, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fzf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major, a.degree
            ORDER BY cnt DESC";

        return $this->executeSelect($sql);
    }

    public function getDegreesInBl2()
    {
        $sql = "SELECT a.major, a.degree, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE block != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream AND a.group_number=b.group_number
            GROUP BY a.major, a.degree
            ORDER BY cnt DESC";

        return $this->executeSelect($sql);
    }

    public function getStreamsInFMI()
    {
        $sql = "SELECT a.major, a.degree, a.years, a.stream, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fmi != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream 
            GROUP BY a.major, a.degree, a.years, a.stream
            ORDER BY  major, years  DESC";

        return $this->executeSelect($sql);
    }

    public function getStreamsInFHF()
    {
        $sql = "SELECT a.major, a.degree, a.years, a.stream, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fhf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream 
            GROUP BY a.major, a.degree, a.years, a.stream
            ORDER BY  major, years  DESC";

        return $this->executeSelect($sql);
    }

    public function getStreamsInFZF()
    {
        $sql = "SELECT a.major, a.degree, a.years, a.stream, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fzf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream 
            GROUP BY a.major, a.degree, a.years, a.stream
            ORDER BY  major, years  DESC";

        return $this->executeSelect($sql);
    }

    public function getStreamsInBl2()
    {
        $sql = "SELECT a.major, a.degree, a.years, a.stream, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE block != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year, stream
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year AND a.stream=b.stream 
            GROUP BY a.major, a.degree, a.years, a.stream
            ORDER BY  major, years  DESC";

        return $this->executeSelect($sql);
    }

    public function getYearsInFMI()
    {
        $sql = "SELECT a.major, a.degree, a.years, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fmi != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year
            GROUP BY a.major, a.degree, a.years, a.stream
            ORDER BY  major, years  DESC";

        return $this->executeSelect($sql);
    }

    public function getYearsInFHF()
    {
        $sql = "SELECT a.major, a.degree, a.years, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fhf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year
            GROUP BY a.major, a.degree, a.years, a.stream
            ORDER BY  major, years  DESC";

        return $this->executeSelect($sql);
    }

    public function getYearsInFZF()
    {
        $sql = "SELECT a.major, a.degree, a.years, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE fzf != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year
            GROUP BY a.major, a.degree, a.years, a.stream
            ORDER BY  major, years  DESC";

        return $this->executeSelect($sql);
    }

    public function getYearsInBl2()
    {
        $sql = "SELECT a.major, a.degree, a.years, COUNT(*) as cnt  FROM
            (SELECT * FROM `distribution`
                        WHERE block != 0) a
                        JOIN
                        (SELECT group_number, major, major_full_name, degree, year
                            FROM `students-fmi`) b
                            ON a.major=b.major AND a.degree=b.degree AND a.years=b.year
            GROUP BY a.major, a.degree, a.years, a.stream
            ORDER BY  major, years  DESC";

        return $this->executeSelect($sql);
    }

    private function executeSelect($sql)
    {
        $query = $this->connection->query($sql) or die("Query failed.");
        $result = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }

}
