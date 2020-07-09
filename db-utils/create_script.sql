CREATE TABLE `students-fmi` (
 `fn` int(11) NOT NULL,
 `degree` varchar(20) CHARACTER SET cp1251 COLLATE cp1251_bulgarian_ci NOT NULL,
 `major` varchar(20) CHARACTER SET cp1251 COLLATE cp1251_bulgarian_ci NOT NULL,
 `major_full_name` VARCHAR(250 bytes) NOT NULL,
 `year` int(11) NOT NULL,
 `stream` int(11) NOT NULL,
 `group_number` int(11) NOT NULL,
 PRIMARY KEY (`fn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4