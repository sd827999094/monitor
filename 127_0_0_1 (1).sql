-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-06-12 17:25:28
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `request`
--

INSERT INTO `request` (`id`, `class_name`, `class_id`, `num`, `teacher_id`, `exam_start_time`, `exam_end_time`, `req_t`, `status`, `hour_length`) VALUES
(16, '数字逻辑', '900', 30, '3', '1402466410', '1402470189', '1402152241', '通过', '1'),
(14, '大学英语', '908', 30, '001', '1402095472', '1402181875', '1401980285', '通过', '2'),
(15, '电路理论', '123', 30, '2', '1402224566', '1402228211', '1402138229', '通过', '1');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `res`
--

INSERT INTO `res` (`id`, `request_id`, `room_id`, `monitor_id`, `class_name`, `class_id`, `teacher_name`, `teacher_id`, `start_t`, `end_t`, `monitor_name`, `room_name`) VALUES
(1, 16, '5', '3', '', '', '', '', '', '', '', ''),
(2, 14, '5', '001', '', '', '', '', '', '', '', ''),
(3, 15, '5', '2', '', '', '', '', '', '', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `room`
--

INSERT INTO `room` (`id`, `name`, `num`, `time`) VALUES
(3, '教九402', 60, ''),
(4, '教十201', 50, ''),
(5, '教八401', 40, '1402466410-1402470189,1402095472-1402181875,1402224566-1402228211'),
(6, '教十一505', 40, ''),
(7, '教十一302', 60, '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `sex`, `department`, `teacher_id`, `teacher_pass`, `status`, `busyDate`, `monitor_times`) VALUES
(27, '翟学明', '男', '计算机系', 1, '780c8b98d82a14d2a37f50c2cc0aaaf1', '1', ',1402095472', 0),
(29, '赵雪晶', '女', '计算机系', 2, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', '1402223483,1402224566', 0),
(30, '李岩', '男', '计算机系', 3, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', ',1402466410', 0),
(31, '豹豹', '男', '作死戏', 4, '780c8b98d82a14d2a37f50c2cc0aaaf1', '0', '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
