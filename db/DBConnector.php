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
        $sql = "SELECT COUNT(group_number) AS count, group_number, major, major_full_name, degree
                            FROM `students-fmi`
                            GROUP BY major, group_number
                            ORDER BY count DESC";
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
