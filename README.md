# ToDo

CREATE DATABASE `task`;

CREATE TABLE description (
`id` int(10) NOT NULL AUTO_INCREMENT,
`task` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`text` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`date` date NOT NULL,
`datetime` datetime(6) NOT NULL,
`priority` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
);
