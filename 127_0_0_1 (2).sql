-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-06-13 21:17:23
-- 服务器版本： 5.6.17
-- PHP Version: 5.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `monitor`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `pass`) VALUES
(1, 'admin', '8339ae90a24371075c2093d40dffe2f1');

-- --------------------------------------------------------

--
-- 表的结构 `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(40) NOT NULL,
  `class_id` varchar(30) NOT NULL,
  `num` int(11) NOT NULL,
  `teacher_id` varchar(40) NOT NULL,
  `exam_start_time` varchar(50) NOT NULL,
  `exam_end_time` varchar(50) NOT NULL,
  `req_t` varchar(50) NOT NULL,
  `status` varchar(40) DEFAULT NULL,
  `hour_length` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `request`
--

INSERT INTO `request` (`id`, `class_name`, `class_id`, `num`, `teacher_id`, `exam_start_time`, `exam_end_time`, `req_t`, `status`, `hour_length`) VALUES
(25, '体育', '909', 30, '15', '1404306005', '1404313212', '1402664532', '通过', '2');

-- --------------------------------------------------------

--
-- 表的结构 `res`
--

CREATE TABLE IF NOT EXISTS `res` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `room_id` varchar(10) NOT NULL,
  `monitor_id` varchar(10) NOT NULL,
  `class_name` varchar(40) NOT NULL,
  `class_id` varchar(50) NOT NULL,
  `teacher_name` varchar(50) NOT NULL,
  `teacher_id` varchar(50) NOT NULL,
  `start_t` varchar(50) NOT NULL,
  `end_t` varchar(50) NOT NULL,
  `monitor_name` varchar(100) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `res`
--

INSERT INTO `res` (`id`, `request_id`, `room_id`, `monitor_id`, `class_name`, `class_id`, `teacher_name`, `teacher_id`, `start_t`, `end_t`, `monitor_name`, `room_name`) VALUES
(10, 25, '24', '15', '体育', '909', '李四', '15', '1404306005', '1404313212', '李四', '教九B201');

-- --------------------------------------------------------

--
-- 表的结构 `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `num` int(11) NOT NULL,
  `time` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `room`
--

INSERT INTO `room` (`id`, `name`, `num`, `time`) VALUES
(24, '教九B201', 100, '1404306005-1404313212');

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `sex` varchar(2) NOT NULL,
  `department` varchar(10) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `teacher_pass` varchar(40) NOT NULL,
  `status` varchar(20) NOT NULL,
  `busyDate` varchar(200) NOT NULL,
  `monitor_times` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_id` (`teacher_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `sex`, `department`, `teacher_id`, `teacher_pass`, `status`, `busyDate`, `monitor_times`) VALUES
(37, '崔克斌', '男', '计算机系', 6, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1402660482,1402920831,1403093734,1402920831,1403093734,1402920831,1403093734,1403093734', 0),
(38, '翟学明', '男', '计算机系', 7, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1402660482,1403093734,1402920831', 3),
(39, '李天', '女', '计算机系', 8, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1402920831,1403093734', 2),
(40, '申珍珍', '女', '计算机系', 9, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1402920831,1403093734', 2),
(41, '曹锦刚', '男', '计算机系', 10, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1402920831,1403093734', 2),
(42, '王徳文', '男', '计算机系', 11, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1403093734,1402920831', 2),
(43, '赵一', '女', '英语系', 12, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1403093734,1402920831', 2),
(44, '钱二', '男', '数理系', 13, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1403093734,1402920831', 2),
(45, '孙三', '男', '电力系', 14, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1403093734,1402920831', 2),
(46, '李四', '男', '动力系', 15, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1403093734,1402920831,1404306005', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
