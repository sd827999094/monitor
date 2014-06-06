-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 06 月 06 日 14:00
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `monitor`
--
CREATE DATABASE `monitor` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `monitor`;

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
  `status` varchar(40) NOT NULL,
  `hour_length` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `request`
--

INSERT INTO `request` (`id`, `class_name`, `class_id`, `num`, `teacher_id`, `exam_start_time`, `exam_end_time`, `req_t`, `status`, `hour_length`) VALUES
(11, '高数', '765', 40, '001', '1401925224', '1402011629', '1401810035', '', ''),
(12, '化学', '432', 40, '001', '1402095328', '1402181731', '1401980159', '', ''),
(13, '物理', '8987', 20, '001', '1402095396', '1402181799', '1401980204', '', ''),
(14, '大学英语', '908', 30, '001', '1402095472', '1402181875', '1401980285', '', '2');

-- --------------------------------------------------------

--
-- 表的结构 `res`
--

CREATE TABLE IF NOT EXISTS `res` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `room_id` varchar(10) NOT NULL,
  `monitor_id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `num` int(11) NOT NULL,
  `work_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `work_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `sex` varchar(2) NOT NULL,
  `department` varchar(10) NOT NULL,
  `start_work_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_work_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `teacher_id` int(11) NOT NULL,
  `teacher_pass` varchar(40) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_id` (`teacher_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `sex`, `department`, `start_work_time`, `end_work_time`, `teacher_id`, `teacher_pass`, `status`) VALUES
(27, '翟学明', '男', '计算机系', '2014-05-31 09:14:45', '0000-00-00 00:00:00', 1, '780c8b98d82a14d2a37f50c2cc0aaaf1', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
