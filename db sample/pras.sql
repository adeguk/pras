-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2016 at 02:33 PM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pras`
--

-- --------------------------------------------------------

--
-- Table structure for table `bf_academic_session`
--

CREATE TABLE IF NOT EXISTS `bf_academic_session` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `session_title` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `studyMode` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bf_academic_session`
--

INSERT INTO `bf_academic_session` (`id`, `session_title`, `startDate`, `endDate`, `studyMode`, `deleted`, `status`) VALUES
(2, 1, '2013-12-10', '2015-10-01', 1, 0, 1),
(3, 2, '1970-02-04', '1970-02-11', 1, 0, 1),
(4, 2, '1970-02-03', '1970-02-17', 1, 1, 2);

--
-- Stand-in structure for view `bf_contacts_view`
--
CREATE TABLE IF NOT EXISTS `bf_contacts_view` (
`id` int(9)
,`user_id` int(11)
,`firstname` varchar(100)
,`middlename` varchar(100)
,`lastname` varchar(100)
,`fullname` varchar(302)
,`street_line1` varchar(100)
,`street_line2` varchar(100)
,`state` varchar(80)
,`country` varchar(80)
,`lga` varchar(80)
,`postcode` varchar(12)
,`other` varchar(100)
,`telephone` varchar(15)
,`contact_type` int(6)
);
-- --------------------------------------------------------

--
-- Table structure for table `bf_contact_address`
--

CREATE TABLE IF NOT EXISTS `bf_contact_address` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `street_line1` varchar(100) NOT NULL,
  `street_line2` varchar(100) DEFAULT NULL,
  `state_id` int(6) DEFAULT NULL,
  `country_code` char(2) NOT NULL,
  `lga_id` int(6) DEFAULT NULL,
  `postcode` varchar(12) DEFAULT NULL,
  `other` varchar(100) DEFAULT NULL,
  `telephone` varchar(15) NOT NULL,
  `contact_type` int(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lga_id` (`lga_id`),
  KEY `state_id` (`state_id`),
  KEY `user_id` (`user_id`),
  KEY `country_code` (`country_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bf_contact_address`
--

INSERT INTO `bf_contact_address` (`id`, `user_id`, `street_line1`, `street_line2`, `state_id`, `country_code`, `lga_id`, `postcode`, `other`, `telephone`, `contact_type`) VALUES
(1, 1, '32 Ifedore Road', '', 431, 'NG', 592, '', '', '08013131315', 1),
(2, 1, '1 ifedun building', 'maye road', 403, 'NG', 531, NULL, '', '07459343436', 2),
(3, 2, 'adegoroye compound', 'ado road', 431, 'NG', 531, NULL, NULL, '07459363436', 2);

-- --------------------------------------------------------

--
-- Table structure for table `bf_coursebank`
--

CREATE TABLE IF NOT EXISTS `bf_coursebank` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `course_name` (`course_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `bf_coursebank`
--

INSERT INTO `bf_coursebank` (`id`, `course_name`, `dept_id`, `deleted`, `status`) VALUES
(1, 'English Studies', 1, 0, 1),
(2, 'Mass Communication', 2, 0, 1),
(3, 'History and International Studies', 3, 0, 1),
(4, 'Linquistics and Yoruba', 5, 0, 1),
(5, 'Yoruba', 5, 0, 1),
(6, 'Accounting', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bf_course_registration_bank`
--

CREATE TABLE IF NOT EXISTS `bf_course_registration_bank` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `progSubject_id` int(11) NOT NULL,
  `semester_session_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bf_degree`
--

CREATE TABLE IF NOT EXISTS `bf_degree` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `deg_Name` varchar(150) NOT NULL,
  `deg_Abbreviation` varchar(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bf_degree`
--

INSERT INTO `bf_degree` (`id`, `deg_Name`, `deg_Abbreviation`, `deleted`, `status`) VALUES
(1, 'Bachelor of Arts', 'BA', 0, 1),
(2, 'Bachelor of Science', 'B.Sc', 0, 1),
(3, 'Bachelor of Art Education', 'BA.Edu', 0, 1),
(4, 'Bachelor of Science Education', 'BSc.Edu', 0, 1),
(5, 'L.L.B', 'L.L.B', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bf_department`
--

CREATE TABLE IF NOT EXISTS `bf_department` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
  `dept_code` char(4) DEFAULT NULL,
  `fac_id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bf_department`
--

INSERT INTO `bf_department` (`id`, `dept_name`, `dept_code`, `fac_id`, `user_id`, `deleted`, `status`) VALUES
(1, 'SAD', NULL, 1, 0, 0, 1),
(2, 'Public Administration', NULL, 6, 2, 0, 1),
(3, 'Enterpreneurship', '', 7, 0, 0, 1),
(4, 'General Studies', '', 7, 0, 0, 1),
(5, 'Linguistics', '', 2, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bf_education`
--

CREATE TABLE IF NOT EXISTS `bf_education` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `institution` varchar(100) NOT NULL,
  `program` varchar(100) DEFAULT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `certificate` varchar(100) NOT NULL,
  `grade` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bf_education`
--

INSERT INTO `bf_education` (`id`, `user_id`, `institution`, `program`, `startDate`, `endDate`, `certificate`, `grade`, `deleted`) VALUES
(1, 1, 'university of bedfordshire', 'busness information systems', '2010-10-10', '2011-11-26', 'MSc', '2.2', 0),
(2, 1, 'CAC Adu Memorial High School', '', '1992-09-06', '1999-05-28', 'SSCE', 'Eng A3, Math A5, PHY A3, CHE C4, Bio D7', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bf_emergency_contact`
--

CREATE TABLE IF NOT EXISTS `bf_emergency_contact` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `uec_fullname` varchar(100) DEFAULT NULL,
  `uec_contact` varchar(10) DEFAULT NULL,
  `uec_relation` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bf_faculty`
--

CREATE TABLE IF NOT EXISTS `bf_faculty` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `fac_name` varchar(100) NOT NULL,
  `fac_code` char(2) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `bf_faculty`
--

INSERT INTO `bf_faculty` (`id`, `fac_name`, `fac_code`, `user_id`, `deleted`, `status`) VALUES
(1, 'ddfdf', '00', 1, 1, 2),
(2, 'Arts', '01', 0, 0, 1),
(3, 'Education', '02', 0, 0, 1),
(4, 'Law', '03', 2, 0, 1),
(5, 'Science', '04', 0, 0, 1),
(6, 'Social and Management Sciences', '05', 0, 0, 1),
(7, 'Management Sciences', '06', 0, 0, 1),
(8, 'Campus-wide', '07', 0, 0, 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `bf_lga_view`
--
CREATE TABLE IF NOT EXISTS `bf_lga_view` (
`id` int(9)
,`lga_name` varchar(80)
,`literacy` int(6)
,`state` varchar(80)
,`country` varchar(80)
,`deleted` tinyint(1)
);
-- --------------------------------------------------------

--
-- Table structure for table `bf_local_government`
--

CREATE TABLE IF NOT EXISTS `bf_local_government` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `lga_name` varchar(80) NOT NULL,
  `literacy` int(6) DEFAULT '100',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `state_id` (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=776 ;

--
-- Dumping data for table `bf_local_government`
--

INSERT INTO `bf_local_government` (`id`, `state_id`, `lga_name`, `literacy`, `deleted`) VALUES
(1, 403, 'Aba North', 100, 0),
(2, 403, 'Aba South', 100, 0),
(3, 403, 'Arochukwu', 100, 0),
(4, 403, 'Bende', 100, 0),
(5, 403, 'Ikwuano', 100, 0),
(6, 403, 'Isiala Ngwa North', 100, 0),
(7, 403, 'Isiala Ngwa South', 100, 0),
(8, 403, 'Isuikwuato', 100, 0),
(9, 403, 'Obi Ngwa', 100, 0),
(10, 403, 'Ohafia', 100, 0),
(11, 403, 'Osisioma', 100, 0),
(12, 403, 'Ugwunagbo', 100, 0),
(13, 403, 'Ukwa East', 100, 0),
(14, 403, 'Ukwa West', 100, 0),
(15, 403, 'Umuahia North', 100, 0),
(16, 403, 'Umuahia South', 100, 0),
(17, 403, 'Umu Nneochi', 100, 0),
(18, 404, 'Demsa', 100, 0),
(19, 404, 'Fufure', 100, 0),
(20, 404, 'Ganye', 100, 0),
(21, 404, 'Gayuk', 100, 0),
(22, 404, 'Gombi', 100, 0),
(23, 404, 'Grie', 100, 0),
(24, 404, 'Hong', 100, 0),
(25, 404, 'Jada', 100, 0),
(26, 404, 'Lamurde', 100, 0),
(27, 404, 'Madagali', 100, 0),
(28, 404, 'Maiha', 100, 0),
(29, 404, 'Mayo Belwa', 100, 0),
(30, 404, 'Michika', 100, 0),
(31, 404, 'Mubi North', 100, 0),
(32, 404, 'Mubi South', 100, 0),
(33, 404, 'Numan', 100, 0),
(34, 404, 'Shelleng', 100, 0),
(35, 404, 'Song', 100, 0),
(36, 404, 'Toungo', 100, 0),
(37, 404, 'Yola North', 100, 0),
(38, 404, 'Yola South', 100, 0),
(39, 405, 'Abak', 100, 0),
(40, 405, 'Eastern Obolo', 100, 0),
(41, 405, 'Eket', 100, 0),
(42, 405, 'Esit Eket', 100, 0),
(43, 405, 'Essien Udim', 100, 0),
(44, 405, 'Etim Ekpo', 100, 0),
(45, 405, 'Etinan', 100, 0),
(46, 405, 'Ibeno', 100, 0),
(47, 405, 'Ibesikpo Asutan', 100, 0),
(48, 405, 'Ibiono-Ibom', 100, 0),
(49, 405, 'Ika', 100, 0),
(50, 405, 'Ikono', 100, 0),
(51, 405, 'Ikot Abasi', 100, 0),
(52, 405, 'Ikot Ekpene', 100, 0),
(53, 405, 'Ini', 100, 0),
(54, 405, 'Itu', 100, 0),
(55, 405, 'Mbo', 100, 0),
(56, 405, 'Mkpat-Enin', 100, 0),
(57, 405, 'Nsit-Atai', 100, 0),
(58, 405, 'Nsit-Ibom', 100, 0),
(59, 405, 'Nsit-Ubium', 100, 0),
(60, 405, 'Obot Akara', 100, 0),
(61, 405, 'Okobo', 100, 0),
(62, 405, 'Onna', 100, 0),
(63, 405, 'Oron', 100, 0),
(64, 405, 'Oruk Anam', 100, 0),
(65, 405, 'Udung-Uko', 100, 0),
(66, 405, 'Ukanafun', 100, 0),
(67, 405, 'Uruan', 100, 0),
(68, 405, 'Urue-Offong - Oruko', 100, 0),
(69, 405, 'Uyo', 100, 0),
(70, 406, 'Aguata', 100, 0),
(71, 406, 'Anambra East', 100, 0),
(72, 406, 'Anambra West', 100, 0),
(73, 406, 'Anaocha', 100, 0),
(74, 406, 'Awka North', 100, 0),
(75, 406, 'Awka South', 100, 0),
(76, 406, 'Ayamelum', 100, 0),
(77, 406, 'Dunukofia', 100, 0),
(78, 406, 'Ekwusigo', 100, 0),
(79, 406, 'Idemili North', 100, 0),
(80, 406, 'Idemili South', 100, 0),
(81, 406, 'Ihiala', 100, 0),
(82, 406, 'Njikoka', 100, 0),
(83, 406, 'Nnewi North', 100, 0),
(84, 406, 'Nnewi South', 100, 0),
(85, 406, 'Ogbaru', 100, 0),
(86, 406, 'Onitsha North', 100, 0),
(87, 406, 'Onitsha South', 100, 0),
(88, 406, 'Orumba North', 100, 0),
(89, 406, 'Orumba South', 100, 0),
(90, 406, 'Oyi', 100, 0),
(91, 407, 'Alkaleri', 100, 0),
(92, 407, 'Bauchi', 100, 0),
(93, 407, 'Bogoro', 100, 0),
(94, 407, 'Damban', 100, 0),
(95, 407, 'Darazo', 100, 0),
(96, 407, 'Dass', 100, 0),
(97, 407, 'Gamawa', 100, 0),
(98, 407, 'Ganjuwa', 100, 0),
(99, 407, 'Giade', 100, 0),
(100, 407, 'Itas - Gadau', 100, 0),
(101, 407, 'Jama''are', 100, 0),
(102, 407, 'Katagum', 100, 0),
(103, 407, 'Kirfi', 100, 0),
(104, 407, 'Misau', 100, 0),
(105, 407, 'Ningi', 100, 0),
(106, 407, 'Shira', 100, 0),
(107, 407, 'Tafawa Balewa', 100, 0),
(108, 407, 'Toro', 100, 0),
(109, 407, 'Warji', 100, 0),
(110, 407, 'Zaki', 100, 0),
(111, 408, 'Brass', 100, 0),
(112, 408, 'Ekeremor', 100, 0),
(113, 408, 'Kolokuma - Opokuma', 100, 0),
(114, 408, 'Nembe', 100, 0),
(115, 408, 'Ogbia', 100, 0),
(116, 408, 'Sagbama', 100, 0),
(117, 408, 'Southern Ijaw', 100, 0),
(118, 408, 'Yenagoa', 100, 0),
(119, 409, 'Agatu', 100, 0),
(120, 409, 'Apa', 100, 0),
(121, 409, 'Ado', 100, 0),
(122, 409, 'Buruku', 100, 0),
(123, 409, 'Gboko', 100, 0),
(124, 409, 'Guma', 100, 0),
(125, 409, 'Gwer East', 100, 0),
(126, 409, 'Gwer West', 100, 0),
(127, 409, 'Katsina-Ala', 100, 0),
(128, 409, 'Konshisha', 100, 0),
(129, 409, 'Kwande', 100, 0),
(130, 409, 'Logo', 100, 0),
(131, 409, 'Makurdi', 100, 0),
(132, 409, 'Obi', 100, 0),
(133, 409, 'Ogbadibo', 100, 0),
(134, 409, 'Ohimini', 100, 0),
(135, 409, 'Oju', 100, 0),
(136, 409, 'Okpokwu', 100, 0),
(137, 409, 'Oturkpo', 100, 0),
(138, 409, 'Tarka', 100, 0),
(139, 409, 'Ukum', 100, 0),
(140, 409, 'Ushongo', 100, 0),
(141, 409, 'Vandeikya', 100, 0),
(142, 410, 'Abadam', 100, 0),
(143, 410, 'Askira - Uba', 100, 0),
(144, 410, 'Bama', 100, 0),
(145, 410, 'Bayo', 100, 0),
(146, 410, 'Biu', 100, 0),
(147, 410, 'Chibok', 100, 0),
(148, 410, 'Damboa', 100, 0),
(149, 410, 'Dikwa', 100, 0),
(150, 410, 'Gubio', 100, 0),
(151, 410, 'Guzamala', 100, 0),
(152, 410, 'Gwoza', 100, 0),
(153, 410, 'Hawul', 100, 0),
(154, 410, 'Jere', 100, 0),
(155, 410, 'Kaga', 100, 0),
(156, 410, 'Kala - Balge', 100, 0),
(157, 410, 'Konduga', 100, 0),
(158, 410, 'Kukawa', 100, 0),
(159, 410, 'Kwaya Kusar', 100, 0),
(160, 410, 'Mafa', 100, 0),
(161, 410, 'Magumeri', 100, 0),
(162, 410, 'Maiduguri', 100, 0),
(163, 410, 'Marte', 100, 0),
(164, 410, 'Mobbar', 100, 0),
(165, 410, 'Monguno', 100, 0),
(166, 410, 'Ngala', 100, 0),
(167, 410, 'Nganzai', 100, 0),
(168, 410, 'Shani', 100, 0),
(169, 411, 'Abi', 100, 0),
(170, 411, 'Akamkpa', 100, 0),
(171, 411, 'Akpabuyo', 100, 0),
(172, 411, 'Bakassi', 100, 0),
(173, 411, 'Bekwarra', 100, 0),
(174, 411, 'Biase', 100, 0),
(175, 411, 'Boki', 100, 0),
(176, 411, 'Calabar Municipal', 100, 0),
(177, 411, 'Calabar South', 100, 0),
(178, 411, 'Etung', 100, 0),
(179, 411, 'Ikom', 100, 0),
(180, 411, 'Obanliku', 100, 0),
(181, 411, 'Obubra', 100, 0),
(182, 411, 'Obudu', 100, 0),
(183, 411, 'Odukpani', 100, 0),
(184, 411, 'Ogoja', 100, 0),
(185, 411, 'Yakuur', 100, 0),
(186, 411, 'Yala', 100, 0),
(187, 412, 'Aniocha North', 100, 0),
(188, 412, 'Aniocha South', 100, 0),
(189, 412, 'Bomadi', 100, 0),
(190, 412, 'Burutu', 100, 0),
(191, 412, 'Ethiope East', 100, 0),
(192, 412, 'Ethiope West', 100, 0),
(193, 412, 'Ika North East', 100, 0),
(194, 412, 'Ika South', 100, 0),
(195, 412, 'Isoko North', 100, 0),
(196, 412, 'Isoko South', 100, 0),
(197, 412, 'Ndokwa East', 100, 0),
(198, 412, 'Ndokwa West', 100, 0),
(199, 412, 'Okpe', 100, 0),
(200, 412, 'Oshimili North', 100, 0),
(201, 412, 'Oshimili South', 100, 0),
(202, 412, 'Patani', 100, 0),
(203, 412, 'Sapele', 100, 0),
(204, 412, 'Udu', 100, 0),
(205, 412, 'Ughelli North', 100, 0),
(206, 412, 'Ughelli South', 100, 0),
(207, 412, 'Ukwuani', 100, 0),
(208, 412, 'Uvwie', 100, 0),
(209, 412, 'Warri North', 100, 0),
(210, 412, 'Warri South', 100, 0),
(211, 412, 'Warri South West', 100, 0),
(212, 413, 'Abakaliki', 100, 0),
(213, 413, 'Afikpo North', 100, 0),
(214, 413, 'Afikpo South', 100, 0),
(215, 413, 'Ebonyi', 100, 0),
(216, 413, 'Ezza North', 100, 0),
(217, 413, 'Ezza South', 100, 0),
(218, 413, 'Ikwo', 100, 0),
(219, 413, 'Ishielu', 100, 0),
(220, 413, 'Ivo', 100, 0),
(221, 413, 'Izzi', 100, 0),
(222, 413, 'Ohaozara', 100, 0),
(223, 413, 'Ohaukwu', 100, 0),
(224, 413, 'Onicha', 100, 0),
(225, 414, 'Akoko-Edo', 100, 0),
(226, 414, 'Egor', 100, 0),
(227, 414, 'Esan Central', 100, 0),
(228, 414, 'Esan North-East', 100, 0),
(229, 414, 'Esan South-East', 100, 0),
(230, 414, 'Esan West', 100, 0),
(231, 414, 'Etsako Central', 100, 0),
(232, 414, 'Etsako East', 100, 0),
(233, 414, 'Etsako West', 100, 0),
(234, 414, 'Igueben', 100, 0),
(235, 414, 'Ikpoba Okha', 100, 0),
(236, 414, 'Orhionmwon', 100, 0),
(237, 414, 'Oredo', 100, 0),
(238, 414, 'Ovia North-East', 100, 0),
(239, 414, 'Ovia South-West', 100, 0),
(240, 414, 'Owan East', 100, 0),
(241, 414, 'Owan West', 100, 0),
(242, 414, 'Uhunmwonde', 100, 0),
(243, 415, 'Ado Ekiti', 100, 0),
(244, 415, 'Efon', 100, 0),
(245, 415, 'Ekiti East', 100, 0),
(246, 415, 'Ekiti South-West', 100, 0),
(247, 415, 'Ekiti West', 100, 0),
(248, 415, 'Emure', 100, 0),
(249, 415, 'Gbonyin', 100, 0),
(250, 415, 'Ido Osi', 100, 0),
(251, 415, 'Ijero', 100, 0),
(252, 415, 'Ikere', 100, 0),
(253, 415, 'Ikole', 100, 0),
(254, 415, 'Ilejemeje', 100, 0),
(255, 415, 'Irepodun - Ifelodun', 100, 0),
(256, 415, 'Ise - Orun', 100, 0),
(257, 415, 'Moba', 100, 0),
(258, 415, 'Oye', 100, 0),
(259, 416, 'Aninri', 100, 0),
(260, 416, 'Awgu', 100, 0),
(261, 416, 'Enugu East', 100, 0),
(262, 416, 'Enugu North', 100, 0),
(263, 416, 'Enugu South', 100, 0),
(264, 416, 'Ezeagu', 100, 0),
(265, 416, 'Igbo Etiti', 100, 0),
(266, 416, 'Igbo Eze North', 100, 0),
(267, 416, 'Igbo Eze South', 100, 0),
(268, 416, 'Isi Uzo', 100, 0),
(269, 416, 'Nkanu East', 100, 0),
(270, 416, 'Nkanu West', 100, 0),
(271, 416, 'Nsukka', 100, 0),
(272, 416, 'Oji River', 100, 0),
(273, 416, 'Udenu', 100, 0),
(274, 416, 'Udi', 100, 0),
(275, 416, 'Uzo Uwani', 100, 0),
(276, 417, 'Abaji', 100, 0),
(277, 417, 'Bwari', 100, 0),
(278, 417, 'Gwagwalada', 100, 0),
(279, 417, 'Kuje', 100, 0),
(280, 417, 'Kwali', 100, 0),
(281, 417, 'Municipal Area Council', 100, 0),
(282, 418, 'Akko', 100, 0),
(283, 418, 'Balanga', 100, 0),
(284, 418, 'Billiri', 100, 0),
(285, 418, 'Dukku', 100, 0),
(286, 418, 'Funakaye', 100, 0),
(287, 418, 'Gombe', 100, 0),
(288, 418, 'Kaltungo', 100, 0),
(289, 418, 'Kwami', 100, 0),
(290, 418, 'Nafada', 100, 0),
(291, 418, 'Shongom', 100, 0),
(292, 418, 'Yamaltu - Deba', 100, 0),
(293, 419, 'Aboh Mbaise', 100, 0),
(294, 419, 'Ahiazu Mbaise', 100, 0),
(295, 419, 'Ehime Mbano', 100, 0),
(296, 419, 'Ezinihitte', 100, 0),
(297, 419, 'Ideato North', 100, 0),
(298, 419, 'Ideato South', 100, 0),
(299, 419, 'Ihitte - Uboma', 100, 0),
(300, 419, 'Ikeduru', 100, 0),
(301, 419, 'Isiala Mbano', 100, 0),
(302, 419, 'Isu', 100, 0),
(303, 419, 'Mbaitoli', 100, 0),
(304, 419, 'Ngor Okpala', 100, 0),
(305, 419, 'Njaba', 100, 0),
(306, 419, 'Nkwerre', 100, 0),
(307, 419, 'Nwangele', 100, 0),
(308, 419, 'Obowo', 100, 0),
(309, 419, 'Oguta', 100, 0),
(310, 419, 'Ohaji - Egbema', 100, 0),
(311, 419, 'Okigwe', 100, 0),
(312, 419, 'Orlu', 100, 0),
(313, 419, 'Orsu', 100, 0),
(314, 419, 'Oru East', 100, 0),
(315, 419, 'Oru West', 100, 0),
(316, 419, 'Owerri Municipal', 100, 0),
(317, 419, 'Owerri North', 100, 0),
(318, 419, 'Owerri West', 100, 0),
(319, 419, 'Unuimo', 100, 0),
(320, 420, 'Auyo', 100, 0),
(321, 420, 'Babura', 100, 0),
(322, 420, 'Biriniwa', 100, 0),
(323, 420, 'Birnin Kudu', 100, 0),
(324, 420, 'Buji', 100, 0),
(325, 420, 'Dutse', 100, 0),
(326, 420, 'Gagarawa', 100, 0),
(327, 420, 'Garki', 100, 0),
(328, 420, 'Gumel', 100, 0),
(329, 420, 'Guri', 100, 0),
(330, 420, 'Gwaram', 100, 0),
(331, 420, 'Gwiwa', 100, 0),
(332, 420, 'Hadejia', 100, 0),
(333, 420, 'Jahun', 100, 0),
(334, 420, 'Kafin Hausa', 100, 0),
(335, 420, 'Kazaure', 100, 0),
(336, 420, 'Kiri Kasama', 100, 0),
(337, 420, 'Kiyawa', 100, 0),
(338, 420, 'Kaugama', 100, 0),
(339, 420, 'Maigatari', 100, 0),
(340, 420, 'Malam Madori', 100, 0),
(341, 420, 'Miga', 100, 0),
(342, 420, 'Ringim', 100, 0),
(343, 420, 'Roni', 100, 0),
(344, 420, 'Sule Tankarkar', 100, 0),
(345, 420, 'Taura', 100, 0),
(346, 420, 'Yankwashi', 100, 0),
(347, 421, 'Birnin Gwari', 100, 0),
(348, 421, 'Chikun', 100, 0),
(349, 421, 'Giwa', 100, 0),
(350, 421, 'Igabi', 100, 0),
(351, 421, 'Ikara', 100, 0),
(352, 421, 'Jaba', 100, 0),
(353, 421, 'Jema''a', 100, 0),
(354, 421, 'Kachia', 100, 0),
(355, 421, 'Kaduna North', 100, 0),
(356, 421, 'Kaduna South', 100, 0),
(357, 421, 'Kagarko', 100, 0),
(358, 421, 'Kajuru', 100, 0),
(359, 421, 'Kaura', 100, 0),
(360, 421, 'Kauru', 100, 0),
(361, 421, 'Kubau', 100, 0),
(362, 421, 'Kudan', 100, 0),
(363, 421, 'Lere', 100, 0),
(364, 421, 'Makarfi', 100, 0),
(365, 421, 'Sabon Gari', 100, 0),
(366, 421, 'Sanga', 100, 0),
(367, 421, 'Soba', 100, 0),
(368, 421, 'Zangon Kataf', 100, 0),
(369, 421, 'Zaria', 100, 0),
(370, 422, 'Ajingi', 100, 0),
(371, 422, 'Albasu', 100, 0),
(372, 422, 'Bagwai', 100, 0),
(373, 422, 'Bebeji', 100, 0),
(374, 422, 'Bichi', 100, 0),
(375, 422, 'Bunkure', 100, 0),
(376, 422, 'Dala', 100, 0),
(377, 422, 'Dambatta', 100, 0),
(378, 422, 'Dawakin Kudu', 100, 0),
(379, 422, 'Dawakin Tofa', 100, 0),
(380, 422, 'Doguwa', 100, 0),
(381, 422, 'Fagge', 100, 0),
(382, 422, 'Gabasawa', 100, 0),
(383, 422, 'Garko', 100, 0),
(384, 422, 'Garun Mallam', 100, 0),
(385, 422, 'Gaya', 100, 0),
(386, 422, 'Gezawa', 100, 0),
(387, 422, 'Gwale', 100, 0),
(388, 422, 'Gwarzo', 100, 0),
(389, 422, 'Kabo', 100, 0),
(390, 422, 'Kano Municipal', 100, 0),
(391, 422, 'Karaye', 100, 0),
(392, 422, 'Kibiya', 100, 0),
(393, 422, 'Kiru', 100, 0),
(394, 422, 'Kumbotso', 100, 0),
(395, 422, 'Kunchi', 100, 0),
(396, 422, 'Kura', 100, 0),
(397, 422, 'Madobi', 100, 0),
(398, 422, 'Makoda', 100, 0),
(399, 422, 'Minjibir', 100, 0),
(400, 422, 'Nasarawa', 100, 0),
(401, 422, 'Rano', 100, 0),
(402, 422, 'Rimin Gado', 100, 0),
(403, 422, 'Rogo', 100, 0),
(404, 422, 'Shanono', 100, 0),
(405, 422, 'Sumaila', 100, 0),
(406, 422, 'Takai', 100, 0),
(407, 422, 'Tarauni', 100, 0),
(408, 422, 'Tofa', 100, 0),
(409, 422, 'Tsanyawa', 100, 0),
(410, 422, 'Tudun Wada', 100, 0),
(411, 422, 'Ungogo', 100, 0),
(412, 422, 'Warawa', 100, 0),
(413, 422, 'Wudil', 100, 0),
(414, 423, 'Bakori', 100, 0),
(415, 423, 'Batagarawa', 100, 0),
(416, 423, 'Batsari', 100, 0),
(417, 423, 'Baure', 100, 0),
(418, 423, 'Bindawa', 100, 0),
(419, 423, 'Charanchi', 100, 0),
(420, 423, 'Dandume', 100, 0),
(421, 423, 'Danja', 100, 0),
(422, 423, 'Dan Musa', 100, 0),
(423, 423, 'Daura', 100, 0),
(424, 423, 'Dutsi', 100, 0),
(425, 423, 'Dutsin Ma', 100, 0),
(426, 423, 'Faskari', 100, 0),
(427, 423, 'Funtua', 100, 0),
(428, 423, 'Ingawa', 100, 0),
(429, 423, 'Jibia', 100, 0),
(430, 423, 'Kafur', 100, 0),
(431, 423, 'Kaita', 100, 0),
(432, 423, 'Kankara', 100, 0),
(433, 423, 'Kankia', 100, 0),
(434, 423, 'Katsina', 100, 0),
(435, 423, 'Kurfi', 100, 0),
(436, 423, 'Kusada', 100, 0),
(437, 423, 'Mai''Adua', 100, 0),
(438, 423, 'Malumfashi', 100, 0),
(439, 423, 'Mani', 100, 0),
(440, 423, 'Mashi', 100, 0),
(441, 423, 'Matazu', 100, 0),
(442, 423, 'Musawa', 100, 0),
(443, 423, 'Rimi', 100, 0),
(444, 423, 'Sabuwa', 100, 0),
(445, 423, 'Safana', 100, 0),
(446, 423, 'Sandamu', 100, 0),
(447, 423, 'Zango', 100, 0),
(448, 424, 'Aleiro', 100, 0),
(449, 424, 'Arewa Dandi', 100, 0),
(450, 424, 'Argungu', 100, 0),
(451, 424, 'Augie', 100, 0),
(452, 424, 'Bagudo', 100, 0),
(453, 424, 'Birnin Kebbi', 100, 0),
(454, 424, 'Bunza', 100, 0),
(455, 424, 'Dandi', 100, 0),
(456, 424, 'Fakai', 100, 0),
(457, 424, 'Gwandu', 100, 0),
(458, 424, 'Jega', 100, 0),
(459, 424, 'Kalgo', 100, 0),
(460, 424, 'Koko - Besse', 100, 0),
(461, 424, 'Maiyama', 100, 0),
(462, 424, 'Ngaski', 100, 0),
(463, 424, 'Sakaba', 100, 0),
(464, 424, 'Shanga', 100, 0),
(465, 424, 'Suru', 100, 0),
(466, 424, 'Wasagu - Danko', 100, 0),
(467, 424, 'Yauri', 100, 0),
(468, 424, 'Zuru', 100, 0),
(469, 425, 'Adavi', 100, 0),
(470, 425, 'Ajaokuta', 100, 0),
(471, 425, 'Ankpa', 100, 0),
(472, 425, 'Bassa', 100, 0),
(473, 425, 'Dekina', 100, 0),
(474, 425, 'Ibaji', 100, 0),
(475, 425, 'Idah', 100, 0),
(476, 425, 'Igalamela Odolu', 100, 0),
(477, 425, 'Ijumu', 100, 0),
(478, 425, 'Kabba - Bunu', 100, 0),
(479, 425, 'Kogi', 100, 0),
(480, 425, 'Lokoja', 100, 0),
(481, 425, 'Mopa Muro', 100, 0),
(482, 425, 'Ofu', 100, 0),
(483, 425, 'Ogori - Magongo', 100, 0),
(484, 425, 'Okehi', 100, 0),
(485, 425, 'Okene', 100, 0),
(486, 425, 'Olamaboro', 100, 0),
(487, 425, 'Omala', 100, 0),
(488, 425, 'Yagba East', 100, 0),
(489, 425, 'Yagba West', 100, 0),
(490, 426, 'Asa', 100, 0),
(491, 426, 'Baruten', 100, 0),
(492, 426, 'Edu', 100, 0),
(493, 426, 'Ekiti', 100, 0),
(494, 426, 'Ifelodun', 100, 0),
(495, 426, 'Ilorin East', 100, 0),
(496, 426, 'Ilorin South', 100, 0),
(497, 426, 'Ilorin West', 100, 0),
(498, 426, 'Irepodun', 100, 0),
(499, 426, 'Isin', 100, 0),
(500, 426, 'Kaiama', 100, 0),
(501, 426, 'Moro', 100, 0),
(502, 426, 'Offa', 100, 0),
(503, 426, 'Oke Ero', 100, 0),
(504, 426, 'Oyun', 100, 0),
(505, 426, 'Pategi', 100, 0),
(506, 427, 'Agege', 100, 0),
(507, 427, 'Ajeromi-Ifelodun', 100, 0),
(508, 427, 'Alimosho', 100, 0),
(509, 427, 'Amuwo-Odofin', 100, 0),
(510, 427, 'Apapa', 100, 0),
(511, 427, 'Badagry', 100, 0),
(512, 427, 'Epe', 100, 0),
(513, 427, 'Eti Osa', 100, 0),
(514, 427, 'Ibeju-Lekki', 100, 0),
(515, 427, 'Ifako-Ijaiye', 100, 0),
(516, 427, 'Ikeja', 100, 0),
(517, 427, 'Ikorodu', 100, 0),
(518, 427, 'Kosofe', 100, 0),
(519, 427, 'Lagos Island', 100, 0),
(520, 427, 'Lagos Mainland', 100, 0),
(521, 427, 'Mushin', 100, 0),
(522, 427, 'Ojo', 100, 0),
(523, 427, 'Oshodi-Isolo', 100, 0),
(524, 427, 'Shomolu', 100, 0),
(525, 427, 'Surulere', 100, 0),
(526, 428, 'Akwanga', 100, 0),
(527, 428, 'Awe', 100, 0),
(528, 428, 'Doma', 100, 0),
(529, 428, 'Karu', 100, 0),
(530, 428, 'Keana', 100, 0),
(531, 428, 'Keffi', 100, 0),
(532, 428, 'Kokona', 100, 0),
(533, 428, 'Lafia', 100, 0),
(534, 428, 'Nasarawa', 100, 0),
(535, 428, 'Nasarawa Egon', 100, 0),
(536, 428, 'Obi', 100, 0),
(537, 428, 'Toto', 100, 0),
(538, 428, 'Wamba', 100, 0),
(539, 429, 'Agaie', 100, 0),
(540, 429, 'Agwara', 100, 0),
(541, 429, 'Bida', 100, 0),
(542, 429, 'Borgu', 100, 0),
(543, 429, 'Bosso', 100, 0),
(544, 429, 'Chanchaga', 100, 0),
(545, 429, 'Edati', 100, 0),
(546, 429, 'Gbako', 100, 0),
(547, 429, 'Gurara', 100, 0),
(548, 429, 'Katcha', 100, 0),
(549, 429, 'Kontagora', 100, 0),
(550, 429, 'Lapai', 100, 0),
(551, 429, 'Lavun', 100, 0),
(552, 429, 'Magama', 100, 0),
(553, 429, 'Mariga', 100, 0),
(554, 429, 'Mashegu', 100, 0),
(555, 429, 'Mokwa', 100, 0),
(556, 429, 'Moya', 100, 0),
(557, 429, 'Paikoro', 100, 0),
(558, 429, 'Rafi', 100, 0),
(559, 429, 'Rijau', 100, 0),
(560, 429, 'Shiroro', 100, 0),
(561, 429, 'Suleja', 100, 0),
(562, 429, 'Tafa', 100, 0),
(563, 429, 'Wushishi', 100, 0),
(564, 430, 'Abeokuta North', 100, 0),
(565, 430, 'Abeokuta South', 100, 0),
(566, 430, 'Ado-Odo - Ota', 100, 0),
(567, 430, 'Egbado North', 100, 0),
(568, 430, 'Egbado South', 100, 0),
(569, 430, 'Ewekoro', 100, 0),
(570, 430, 'Ifo', 100, 0),
(571, 430, 'Ijebu East', 100, 0),
(572, 430, 'Ijebu North', 100, 0),
(573, 430, 'Ijebu North East', 100, 0),
(574, 430, 'Ijebu Ode', 100, 0),
(575, 430, 'Ikenne', 100, 0),
(576, 430, 'Imeko Afon', 100, 0),
(577, 430, 'Ipokia', 100, 0),
(578, 430, 'Obafemi Owode', 100, 0),
(579, 430, 'Odeda', 100, 0),
(580, 430, 'Odogbolu', 100, 0),
(581, 430, 'Ogun Waterside', 100, 0),
(582, 430, 'Remo North', 100, 0),
(583, 430, 'Shagamu', 100, 0),
(584, 431, 'Akoko North-East', 100, 0),
(585, 431, 'Akoko North-West', 100, 0),
(586, 431, 'Akoko South-West', 100, 0),
(587, 431, 'Akoko South-East', 100, 0),
(588, 431, 'Akure North', 100, 0),
(589, 431, 'Akure South', 100, 0),
(590, 431, 'Ese Odo', 100, 0),
(591, 431, 'Idanre', 100, 0),
(592, 431, 'Ifedore', 100, 0),
(593, 431, 'Ilaje', 100, 0),
(594, 431, 'Ile Oluji - Okeigbo', 100, 0),
(595, 431, 'Irele', 100, 0),
(596, 431, 'Odigbo', 100, 0),
(597, 431, 'Okitipupa', 100, 0),
(598, 431, 'Ondo East', 100, 0),
(599, 431, 'Ondo West', 100, 0),
(600, 431, 'Ose', 100, 0),
(601, 431, 'Owo', 100, 0),
(602, 432, 'Atakunmosa East', 100, 0),
(603, 432, 'Atakunmosa West', 100, 0),
(604, 432, 'Aiyedaade', 100, 0),
(605, 432, 'Aiyedire', 100, 0),
(606, 432, 'Boluwaduro', 100, 0),
(607, 432, 'Boripe', 100, 0),
(608, 432, 'Ede North', 100, 0),
(609, 432, 'Ede South', 100, 0),
(610, 432, 'Ife Central', 100, 0),
(611, 432, 'Ife East', 100, 0),
(612, 432, 'Ife North', 100, 0),
(613, 432, 'Ife South', 100, 0),
(614, 432, 'Egbedore', 100, 0),
(615, 432, 'Ejigbo', 100, 0),
(616, 432, 'Ifedayo', 100, 0),
(617, 432, 'Ifelodun', 100, 0),
(618, 432, 'Ila', 100, 0),
(619, 432, 'Ilesa East', 100, 0),
(620, 432, 'Ilesa West', 100, 0),
(621, 432, 'Irepodun', 100, 0),
(622, 432, 'Irewole', 100, 0),
(623, 432, 'Isokan', 100, 0),
(624, 432, 'Iwo', 100, 0),
(625, 432, 'Obokun', 100, 0),
(626, 432, 'Odo Otin', 100, 0),
(627, 432, 'Ola Oluwa', 100, 0),
(628, 432, 'Olorunda', 100, 0),
(629, 432, 'Oriade', 100, 0),
(630, 432, 'Orolu', 100, 0),
(631, 432, 'Osogbo', 100, 0),
(632, 433, 'Afijio', 100, 0),
(633, 433, 'Akinyele', 100, 0),
(634, 433, 'Atiba', 100, 0),
(635, 433, 'Atisbo', 100, 0),
(636, 433, 'Egbeda', 100, 0),
(637, 433, 'Ibadan North', 100, 0),
(638, 433, 'Ibadan North-East', 100, 0),
(639, 433, 'Ibadan North-West', 100, 0),
(640, 433, 'Ibadan South-East', 100, 0),
(641, 433, 'Ibadan South-West', 100, 0),
(642, 433, 'Ibarapa Central', 100, 0),
(643, 433, 'Ibarapa East', 100, 0),
(644, 433, 'Ibarapa North', 100, 0),
(645, 433, 'Ido', 100, 0),
(646, 433, 'Irepo', 100, 0),
(647, 433, 'Iseyin', 100, 0),
(648, 433, 'Itesiwaju', 100, 0),
(649, 433, 'Iwajowa', 100, 0),
(650, 433, 'Kajola', 100, 0),
(651, 433, 'Lagelu', 100, 0),
(652, 433, 'Ogbomosho North', 100, 0),
(653, 433, 'Ogbomosho South', 100, 0),
(654, 433, 'Ogo Oluwa', 100, 0),
(655, 433, 'Olorunsogo', 100, 0),
(656, 433, 'Oluyole', 100, 0),
(657, 433, 'Ona Ara', 100, 0),
(658, 433, 'Orelope', 100, 0),
(659, 433, 'Ori Ire', 100, 0),
(660, 433, 'Oyo', 100, 0),
(661, 433, 'Oyo East', 100, 0),
(662, 433, 'Saki East', 100, 0),
(663, 433, 'Saki West', 100, 0),
(664, 433, 'Surulere', 100, 0),
(665, 434, 'Bokkos', 100, 0),
(666, 434, 'Barkin Ladi', 100, 0),
(667, 434, 'Bassa', 100, 0),
(668, 434, 'Jos East', 100, 0),
(669, 434, 'Jos North', 100, 0),
(670, 434, 'Jos South', 100, 0),
(671, 434, 'Kanam', 100, 0),
(672, 434, 'Kanke', 100, 0),
(673, 434, 'Langtang South', 100, 0),
(674, 434, 'Langtang North', 100, 0),
(675, 434, 'Mangu', 100, 0),
(676, 434, 'Mikang', 100, 0),
(677, 434, 'Pankshin', 100, 0),
(678, 434, 'Qua''an Pan', 100, 0),
(679, 434, 'Riyom', 100, 0),
(680, 434, 'Shendam', 100, 0),
(681, 434, 'Wase', 100, 0),
(682, 435, 'Abua - Odual', 100, 0),
(683, 435, 'Ahoada East', 100, 0),
(684, 435, 'Ahoada West', 100, 0),
(685, 435, 'Akuku-Toru', 100, 0),
(686, 435, 'Andoni', 100, 0),
(687, 435, 'Asari-Toru', 100, 0),
(688, 435, 'Bonny', 100, 0),
(689, 435, 'Degema', 100, 0),
(690, 435, 'Eleme', 100, 0),
(691, 435, 'Emuoha', 100, 0),
(692, 435, 'Etche', 100, 0),
(693, 435, 'Gokana', 100, 0),
(694, 435, 'Ikwerre', 100, 0),
(695, 435, 'Khana', 100, 0),
(696, 435, 'Obio - Akpor', 100, 0),
(697, 435, 'Ogba - Egbema - Ndoni', 100, 0),
(698, 435, 'Ogu - Bolo', 100, 0),
(699, 435, 'Okrika', 100, 0),
(700, 435, 'Omuma', 100, 0),
(701, 435, 'Opobo - Nkoro', 100, 0),
(702, 435, 'Oyigbo', 100, 0),
(703, 435, 'Port Harcourt', 100, 0),
(704, 435, 'Tai', 100, 0),
(705, 436, 'Binji', 100, 0),
(706, 436, 'Bodinga', 100, 0),
(707, 436, 'Dange Shuni', 100, 0),
(708, 436, 'Gada', 100, 0),
(709, 436, 'Goronyo', 100, 0),
(710, 436, 'Gudu', 100, 0),
(711, 436, 'Gwadabawa', 100, 0),
(712, 436, 'Illela', 100, 0),
(713, 436, 'Isa', 100, 0),
(714, 436, 'Kebbe', 100, 0),
(715, 436, 'Kware', 100, 0),
(716, 436, 'Rabah', 100, 0),
(717, 436, 'Sabon Birni', 100, 0),
(718, 436, 'Shagari', 100, 0),
(719, 436, 'Silame', 100, 0),
(720, 436, 'Sokoto North', 100, 0),
(721, 436, 'Sokoto South', 100, 0),
(722, 436, 'Tambuwal', 100, 0),
(723, 436, 'Tangaza', 100, 0),
(724, 436, 'Tureta', 100, 0),
(725, 436, 'Wamako', 100, 0),
(726, 436, 'Wurno', 100, 0),
(727, 436, 'Yabo', 100, 0),
(728, 437, 'Ardo Kola', 100, 0),
(729, 437, 'Bali', 100, 0),
(730, 437, 'Donga', 100, 0),
(731, 437, 'Gashaka', 100, 0),
(732, 437, 'Gassol', 100, 0),
(733, 437, 'Ibi', 100, 0),
(734, 437, 'Jalingo', 100, 0),
(735, 437, 'Karim Lamido', 100, 0),
(736, 437, 'Kumi', 100, 0),
(737, 437, 'Lau', 100, 0),
(738, 437, 'Sardauna', 100, 0),
(739, 437, 'Takum', 100, 0),
(740, 437, 'Ussa', 100, 0),
(741, 437, 'Wukari', 100, 0),
(742, 437, 'Yorro', 100, 0),
(743, 437, 'Zing', 100, 0),
(744, 438, 'Bade', 100, 0),
(745, 438, 'Bursari', 100, 0),
(746, 438, 'Damaturu', 100, 0),
(747, 438, 'Fika', 100, 0),
(748, 438, 'Fune', 100, 0),
(749, 438, 'Geidam', 100, 0),
(750, 438, 'Gujba', 100, 0),
(751, 438, 'Gulani', 100, 0),
(752, 438, 'Jakusko', 100, 0),
(753, 438, 'Karasuwa', 100, 0),
(754, 438, 'Machina', 100, 0),
(755, 438, 'Nangere', NULL, 0),
(756, 438, 'Nguru', NULL, 0),
(757, 438, 'Potiskum', NULL, 0),
(758, 438, 'Tarmuwa', NULL, 0),
(759, 438, 'Yunusari', NULL, 0),
(760, 438, 'Yusufari', NULL, 0),
(761, 439, 'Anka', NULL, 0),
(762, 439, 'Bakura', NULL, 0),
(763, 439, 'Birnin Magaji - Kiyaw', NULL, 0),
(764, 439, 'Bukkuyum', NULL, 0),
(765, 439, 'Bungudu', NULL, 0),
(766, 439, 'Gummi', NULL, 0),
(767, 439, 'Gusau', NULL, 0),
(768, 439, 'Kaura Namoda', NULL, 0),
(769, 439, 'Maradun', NULL, 0),
(770, 439, 'Maru', NULL, 0),
(771, 439, 'Shinkafi', NULL, 0),
(772, 439, 'Talata Mafara', NULL, 0),
(773, 439, 'Chafe', NULL, 0),
(774, 439, 'Zurmi', NULL, 0),
(775, 440, 'Other', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bf_program`
--

CREATE TABLE IF NOT EXISTS `bf_program` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `deg_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `studyMode` int(6) NOT NULL,
  `progCode` varchar(10) DEFAULT NULL,
  `description` text,
  `duration` int(6) NOT NULL,
  `progStart_level` int(6) NOT NULL,
  `progEnd_level` int(6) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bf_program`
--

INSERT INTO `bf_program` (`id`, `deg_id`, `course_id`, `studyMode`, `progCode`, `description`, `duration`, `progStart_level`, `progEnd_level`, `created_on`, `modified_on`, `deleted`, `status`) VALUES
(1, 2, 6, 1, 'ACC', 'Test passed', 3, 1, 4, '2015-10-14 04:29:12', '2015-10-15 15:53:03', 0, 1),
(2, 4, 6, 1, 'ACE', 'using the same template for edit n create', 3, 1, 4, '2015-10-15 16:06:56', '2015-10-15 16:07:12', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bf_program_subject`
--

CREATE TABLE IF NOT EXISTS `bf_program_subject` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `prog_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `progLevel` int(6) NOT NULL,
  `prog_semester` int(6) NOT NULL,
  `compulsory` int(6) NOT NULL,
  `created_on` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `prog_id` (`prog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bf_program_subject`
--

INSERT INTO `bf_program_subject` (`id`, `prog_id`, `subject_id`, `progLevel`, `prog_semester`, `compulsory`, `created_on`, `deleted`, `status`) VALUES
(1, 1, 2, 1, 1, 1, '2015-10-15 20:10:46', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bf_program_unit`
--

CREATE TABLE IF NOT EXISTS `bf_program_unit` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `prog_id` int(11) NOT NULL,
  `minimum_unit` int(6) NOT NULL,
  `maximum_unit` int(6) NOT NULL,
  `progLevel` int(6) NOT NULL,
  `progSemester` int(6) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bf_program_unit`
--

INSERT INTO `bf_program_unit` (`id`, `prog_id`, `minimum_unit`, `maximum_unit`, `progLevel`, `progSemester`, `status`) VALUES
(1, 2, 3, 4, 1, 1, 1);

-- --------------------------------------------------------
--
-- Dumping data for table `bf_roles`
--

INSERT INTO `bf_roles` (`role_id`, `role_name`, `description`, `default`, `can_delete`, `login_destination`, `default_context`, `deleted`) VALUES
(NULL, 'Students', 'For all current students and alumni', 0, 0, 'users/profile', 'content', 0),
(NULL, 'VC', 'for the Vice Chancellor similar to all principal officers role but just under superadmin', 0, 0, 'users/profile', 'content', 0),
(NULL, 'Bursar', 'Similar to VC but mainly focus on accounting section', 0, 0, 'users/profile', 'content', 0),
(NULL, 'Registrar', 'Like VC and Bursar but focus more on students and other users', 0, 0, 'users/profile', 'content', 0);

-- --------------------------------------------------------
--
-- Table structure for table `bf_session_semester`
--

CREATE TABLE IF NOT EXISTS `bf_session_semester` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `session_semester` int(11) NOT NULL,
  `aca_session_id` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `isCurrent` tinyint(1) NOT NULL DEFAULT '0',
  `isRegistration` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bf_session_semester`
--

INSERT INTO `bf_session_semester` (`id`, `session_semester`, `aca_session_id`, `startDate`, `endDate`, `isCurrent`, `isRegistration`, `deleted`) VALUES
(1, 1, 2, '1970-02-02', '1970-02-04', 1, 1, 0);

-- --------------------------------------------------------
--
-- Table structure for table `bf_states`
--

CREATE TABLE IF NOT EXISTS `bf_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` char(2) NOT NULL,
  `state_name` varchar(80) NOT NULL,
  `state_code` char(6) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `country_code` (`country_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=441 ;

--
-- Dumping data for table `bf_states`
--

INSERT INTO `bf_states` (`id`, `country_code`, `state_name`, `state_code`, `deleted`) VALUES
(1, 'AD', 'Andorra la Vella', 'AD-07', 0),
(2, 'AD', 'Canillo', 'AD-02', 0),
(3, 'AD', 'Encamp', 'AD-03', 0),
(4, 'AD', 'Escaldes-Engordany', 'AD-08', 0),
(5, 'AD', 'La Massana', 'AD-04', 0),
(6, 'AD', 'Ordino', 'AD-05', 0),
(7, 'AD', 'Sant Julia de Loria', 'AD-06', 0),
(8, 'AE', 'Abu Zaby', 'AE-AZ', 0),
(9, 'AE', 'Ajman', 'AE-AJ', 0),
(10, 'AE', 'Al Fujayrah', 'AE-FU', 0),
(11, 'AE', 'Ash Shariqah', 'AE-SH', 0),
(12, 'AE', 'Dubayy', 'AE-DU', 0),
(13, 'AE', 'Ras al Khaymah', 'AE-RK', 0),
(14, 'AE', 'Umm al Qaywayn', 'AE-UQ', 0),
(15, 'AF', 'Badakhshan', 'AF-BDS', 0),
(16, 'AF', 'Badghis', 'AF-BDG', 0),
(17, 'AF', 'Baghlan', 'AF-BGL', 0),
(18, 'AF', 'Balkh', 'AF-BAL', 0),
(19, 'AF', 'Bamyan', 'AF-BAM', 0),
(20, 'AF', 'Daykundi', 'AF-DAY', 0),
(21, 'AF', 'Farah', 'AF-FRA', 0),
(22, 'AF', 'Faryab', 'AF-FYB', 0),
(23, 'AF', 'Ghazni', 'AF-GHA', 0),
(24, 'AF', 'Ghor', 'AF-GHO', 0),
(25, 'AF', 'Helmand', 'AF-HEL', 0),
(26, 'AF', 'Herat', 'AF-HER', 0),
(27, 'AF', 'Jowzjan', 'AF-JOW', 0),
(28, 'AF', 'Kabul', 'AF-KAB', 0),
(29, 'AF', 'Kandahar', 'AF-KAN', 0),
(30, 'AF', 'Kapisa', 'AF-KAP', 0),
(31, 'AF', 'Khost', 'AF-KHO', 0),
(32, 'AF', 'Kunar', 'AF-KNR', 0),
(33, 'AF', 'Kunduz', 'AF-KDZ', 0),
(34, 'AF', 'Laghman', 'AF-LAG', 0),
(35, 'AF', 'Logar', 'AF-LOG', 0),
(36, 'AF', 'Nangarhar', 'AF-NAN', 0),
(37, 'AF', 'Nimroz', 'AF-NIM', 0),
(38, 'AF', 'Nuristan', 'AF-NUR', 0),
(39, 'AF', 'Paktika', 'AF-PKA', 0),
(40, 'AF', 'Paktiya', 'AF-PIA', 0),
(41, 'AF', 'Panjshayr', 'AF-PAN', 0),
(42, 'AF', 'Parwan', 'AF-PAR', 0),
(43, 'AF', 'Samangan', 'AF-SAM', 0),
(44, 'AF', 'Sar-e Pul', 'AF-SAR', 0),
(45, 'AF', 'Takhar', 'AF-TAK', 0),
(46, 'AF', 'Uruzgan', 'AF-URU', 0),
(47, 'AF', 'Wardak', 'AF-WAR', 0),
(48, 'AF', 'Zabul', 'AF-ZAB', 0),
(49, 'AG', 'Saint George', 'AG-03', 0),
(50, 'AG', 'Saint John', 'AG-04', 0),
(51, 'AG', 'Saint Mary', 'AG-05', 0),
(52, 'AG', 'Saint Paul', 'AG-06', 0),
(53, 'AG', 'Saint Peter', 'AG-07', 0),
(54, 'AG', 'Saint Philip', 'AG-08', 0),
(55, 'AG', 'Barbuda', 'AG-10', 0),
(56, 'AG', 'Redonda', 'AG-11', 0),
(57, 'AL', 'Berat', 'AL-BR', 0),
(58, 'AL', 'Bulqiz', 'AL-BU', 0),
(59, 'AL', 'Dib', 'AL-DI', 0),
(60, 'AL', 'Delvin', 'AL-DL', 0),
(61, 'AL', 'Durr', 'AL-DR', 0),
(62, 'AL', 'Devoll', 'AL-DV', 0),
(63, 'AL', 'Elbasan', 'AL-EL', 0),
(64, 'AL', 'Kolonj', 'AL-ER', 0),
(65, 'AL', 'Fier', 'AL-FR', 0),
(66, 'AL', 'Gjirokast', 'AL-GJ', 0),
(67, 'AL', 'Gramsh', 'AL-GR', 0),
(68, 'AL', 'Has', 'AL-HA', 0),
(69, 'AL', 'Kavaj', 'AL-KA', 0),
(70, 'AL', 'Kurbin', 'AL-KB', 0),
(71, 'AL', 'Kucov', 'AL-KC', 0),
(72, 'AL', 'Kor', 'AL-KO', 0),
(73, 'AL', 'Kruj', 'AL-KR', 0),
(74, 'AL', 'Kuk', 'AL-KU', 0),
(75, 'AL', 'Librazhd', 'AL-LB', 0),
(76, 'AL', 'Lezh', 'AL-LE', 0),
(77, 'AL', 'Lushnj', 'AL-LU', 0),
(78, 'AL', 'Mallakast', 'AL-MK', 0),
(79, 'AL', 'Malesi e Madhe', 'AL-MM', 0),
(80, 'AL', 'Mirdit', 'AL-MR', 0),
(81, 'AL', 'Mat', 'AL-MT', 0),
(82, 'AL', 'Pogradec', 'AL-PG', 0),
(83, 'AL', 'Peqin', 'AL-PQ', 0),
(84, 'AL', 'Permet', 'AL-PR', 0),
(85, 'AL', 'Puk', 'AL-PU', 0),
(86, 'AL', 'Shkod', 'AL-SH', 0),
(87, 'AL', 'Skrapar', 'AL-SK', 0),
(88, 'AL', 'Sarand', 'AL-SR', 0),
(89, 'AL', 'Tepelen', 'AL-TE', 0),
(90, 'AL', 'Tropoj', 'AL-TP', 0),
(91, 'AL', 'Tiran', 'AL-TR', 0),
(92, 'AL', 'Vlor', 'AL-VL', 0),
(93, 'AM', 'Aragacotn', 'AM-AG', 0),
(94, 'AM', 'Ararat', 'AM-AR', 0),
(95, 'AM', 'Armavir', 'AM-AV', 0),
(96, 'AM', 'Erevan', 'AM-ER', 0),
(97, 'AM', 'Gegarkunik', 'AM-GR', 0),
(98, 'AM', 'Kotayk', 'AM-KT', 0),
(99, 'AM', 'Lory', 'AM-LO', 0),
(100, 'AM', 'Sirak', 'AM-SH', 0),
(101, 'AM', 'Syunik', 'AM-SU', 0),
(102, 'AM', 'Tavus', 'AM-TV', 0),
(103, 'AM', 'Vayoc Jor', 'AM-VD', 0),
(104, 'AO', 'Bengo', 'AO-BGO', 0),
(105, 'AO', 'Benguela', 'AO-BGU', 0),
(106, 'AO', 'Bi', 'AO-BIE', 0),
(107, 'AO', 'Cabinda', 'AO-CAB', 0),
(108, 'AO', 'Cuando-Cubango', 'AO-CCU', 0),
(109, 'AO', 'Cuanza Norte', 'AO-CNO', 0),
(110, 'AO', 'Cuanza Sul', 'AO-CUS', 0),
(111, 'AO', 'Cunene', 'AO-CNN', 0),
(112, 'AO', 'Huambo', 'AO-HUA', 0),
(113, 'AO', 'Huila', 'AO-HUI', 0),
(114, 'AO', 'Luanda', 'AO-LUA', 0),
(115, 'AO', 'Lunda Norte', 'AO-LNO', 0),
(116, 'AO', 'Lunda Sul', 'AO-LSU', 0),
(117, 'AO', 'Malange', 'AO-MAL', 0),
(118, 'AO', 'Moxico', 'AO-MOX', 0),
(119, 'AO', 'Namibe', 'AO-NAM', 0),
(120, 'AO', 'Uige', 'AO-UIG', 0),
(121, 'AO', 'Zaire', 'AO-ZAI', 0),
(122, 'AR', 'Buenos Aires', 'AR-B', 0),
(123, 'AR', 'Catamarca', 'AR-K', 0),
(124, 'AR', 'Chaco', 'AR-H', 0),
(125, 'AR', 'Chubut', 'AR-U', 0),
(126, 'AR', 'Ciudad Autonoma de Buenos Aires', 'AR-C', 0),
(127, 'AR', 'Cordoba', 'AR-X', 0),
(128, 'AR', 'Corrientes', 'AR-W', 0),
(129, 'AR', 'Entre Rios', 'AR-E', 0),
(130, 'AR', 'Formosa', 'AR-P', 0),
(131, 'AR', 'Jujuy', 'AR-Y', 0),
(132, 'AR', 'La Pampa', 'AR-L', 0),
(133, 'AR', 'La Rioja', 'AR-F', 0),
(134, 'AR', 'Mendoza', 'AR-M', 0),
(135, 'AR', 'Misiones', 'AR-N', 0),
(136, 'AR', 'Neuqu', 'AR-Q', 0),
(137, 'AR', 'Rio Negro', 'AR-R', 0),
(138, 'AR', 'Salta', 'AR-A', 0),
(139, 'AR', 'San Juan', 'AR-J', 0),
(140, 'AR', 'San Luis', 'AR-D', 0),
(141, 'AR', 'Santa Cruz', 'AR-Z', 0),
(142, 'AR', 'Santa Fe', 'AR-S', 0),
(143, 'AR', 'Santiago del Estero', 'AR-G', 0),
(144, 'AR', 'Tierra del Fuego', 'AR-V', 0),
(145, 'AR', 'Tucum', 'AR-T', 0),
(146, 'AT', 'Burgenland', 'AT-1', 0),
(147, 'AT', 'Karnten', 'AT-2', 0),
(148, 'AT', 'Niederosterreich', 'AT-3', 0),
(149, 'AT', 'Oberosterreich', 'AT-4', 0),
(150, 'AT', 'Salzburg', 'AT-5', 0),
(151, 'AT', 'Steiermark', 'AT-6', 0),
(152, 'AT', 'Tirol', 'AT-7', 0),
(153, 'AT', 'Vorarlberg', 'AT-8', 0),
(154, 'AT', 'Wien', 'AT-9', 0),
(155, 'AU', 'New South Wales', 'AU-NSW', 0),
(156, 'AU', 'Queensland', 'AU-QLD', 0),
(157, 'AU', 'South Australia', 'AU-SA', 0),
(158, 'AU', 'Tasmania', 'AU-TAS', 0),
(159, 'AU', 'Victoria', 'AU-VIC', 0),
(160, 'AU', 'Western Australia', 'AU-WA', 0),
(161, 'AU', 'Australian Capital Territory', 'AU-ACT', 0),
(162, 'AU', 'Northern Territory', 'AU-NT', 0),
(163, 'AZ', 'Baki', 'AZ-BA', 0),
(164, 'AZ', 'Ganca', 'AZ-GA', 0),
(165, 'AZ', 'Lankaran', 'AZ-LA', 0),
(166, 'AZ', 'Mingacevir', 'AZ-MI', 0),
(167, 'AZ', 'Naftalan', 'AZ-NA', 0),
(168, 'AZ', 'Naxcivan', 'AZ-NV', 0),
(169, 'AZ', 'Saki', 'AZ-SA', 0),
(170, 'AZ', 'Sirvan', 'AZ-SR', 0),
(171, 'AZ', 'Sumqayit', 'AZ-SM', 0),
(172, 'AZ', 'Xankandi', 'AZ-XA', 0),
(173, 'AZ', 'Yevlax', 'AZ-YE', 0),
(174, 'AZ', 'Abseron', 'AZ-ABS', 0),
(175, 'AZ', 'Agcabadi', 'AZ-AGC', 0),
(176, 'AZ', 'Agdam', 'AZ-AGM', 0),
(177, 'AZ', 'Agdas', 'AZ-AGS', 0),
(178, 'AZ', 'Agstafa', 'AZ-AGA', 0),
(179, 'AZ', 'Agsu', 'AZ-AGU', 0),
(180, 'AZ', 'Astara', 'AZ-AST', 0),
(181, 'AZ', 'Babak', 'AZ-BAB', 0),
(182, 'AZ', 'Balakan', 'AZ-BAL', 0),
(183, 'AZ', 'Barda', 'AZ-BAR', 0),
(184, 'AZ', 'Beyleqan', 'AZ-BEY', 0),
(185, 'AZ', 'Bilasuvar', 'AZ-BIL', 0),
(186, 'AZ', 'Cabrayil', 'AZ-CAB', 0),
(187, 'AZ', 'Calilabad', 'AZ-CAL', 0),
(188, 'AZ', 'Culfa', 'AZ-CUL', 0),
(189, 'AZ', 'Daskasan', 'AZ-DAS', 0),
(190, 'AZ', 'Fuzuli', 'AZ-FUZ', 0),
(191, 'AZ', 'Gadabay', 'AZ-GAD', 0),
(192, 'AZ', 'Goranboy', 'AZ-GOR', 0),
(193, 'AZ', 'Goycay', 'AZ-GOY', 0),
(194, 'AZ', 'Goygol', 'AZ-GYG', 0),
(195, 'AZ', 'Haciqabul', 'AZ-HAC', 0),
(196, 'AZ', 'Imisli', 'AZ-IMI', 0),
(197, 'AZ', 'Ismayilli', 'AZ-ISM', 0),
(198, 'AZ', 'Kalbacar', 'AZ-KAL', 0),
(199, 'AZ', 'Kangarli', 'AZ-KAN', 0),
(200, 'AZ', 'Kurdamir', 'AZ-KUR', 0),
(201, 'AZ', 'Lacin', 'AZ-LAC', 0),
(202, 'AZ', 'Lankaran', 'AZ-LAN', 0),
(203, 'AZ', 'Lerik', 'AZ-LER', 0),
(204, 'AZ', 'Masalli', 'AZ-MAS', 0),
(205, 'AZ', 'Neftcala', 'AZ-NEF', 0),
(206, 'AZ', 'Oguz', 'AZ-OGU', 0),
(207, 'AZ', 'Ordubad', 'AZ-ORD', 0),
(208, 'AZ', 'Qabala', 'AZ-QAB', 0),
(209, 'AZ', 'Qax', 'AZ-QAX', 0),
(210, 'AZ', 'Qazax', 'AZ-QAZ', 0),
(211, 'AZ', 'Qobustan', 'AZ-QOB', 0),
(212, 'AZ', 'Quba', 'AZ-QBA', 0),
(213, 'AZ', 'Qubadli', 'AZ-QBI', 0),
(214, 'AZ', 'Qusar', 'AZ-QUS', 0),
(215, 'AZ', 'Saatli', 'AZ-SAT', 0),
(216, 'AZ', 'Sabirabad', 'AZ-SAB', 0),
(217, 'AZ', 'Sabran', 'AZ-SBN', 0),
(218, 'AZ', 'Sadarak', 'AZ-SAD', 0),
(219, 'AZ', 'Sahbuz', 'AZ-SAH', 0),
(220, 'AZ', 'Saki', 'AZ-SAK', 0),
(221, 'AZ', 'Salyan', 'AZ-SAL', 0),
(222, 'AZ', 'Samaxi', 'AZ-SMI', 0),
(223, 'AZ', 'Samkir', 'AZ-SKR', 0),
(224, 'AZ', 'Samux', 'AZ-SMX', 0),
(225, 'AZ', 'Sarur', 'AZ-SAR', 0),
(226, 'AZ', 'Siyazan', 'AZ-SIY', 0),
(227, 'AZ', 'Susa', 'AZ-SUS', 0),
(228, 'AZ', 'Tartar', 'AZ-TAR', 0),
(229, 'AZ', 'Tovuz', 'AZ-TOV', 0),
(230, 'AZ', 'Ucar', 'AZ-UCA', 0),
(231, 'AZ', 'Xacmaz', 'AZ-XAC', 0),
(232, 'AZ', 'Xizi', 'AZ-XIZ', 0),
(233, 'AZ', 'Xocali', 'AZ-XCI', 0),
(234, 'AZ', 'Xocavand', 'AZ-XVD', 0),
(235, 'AZ', 'Yardimli', 'AZ-YAR', 0),
(236, 'AZ', 'Yevlax', 'AZ-YEV', 0),
(237, 'AZ', 'Zangilan', 'AZ-ZAN', 0),
(238, 'AZ', 'Zaqatala', 'AZ-ZAQ', 0),
(239, 'AZ', 'Zardab', 'AZ-ZAR', 0),
(240, 'BR', 'Acre', 'BR-AC', 0),
(241, 'BR', 'Alagoas', 'BR-AL', 0),
(242, 'BR', 'Amap', 'BR-AP', 0),
(243, 'BR', 'Amazonas', 'BR-AM', 0),
(244, 'BR', 'Bahia', 'BR-BA', 0),
(245, 'BR', 'Cear', 'BR-CE', 0),
(246, 'BR', 'Distrito Federal', 'BR-DF', 0),
(247, 'BR', 'Espirito Santo', 'BR-ES', 0),
(248, 'BR', 'Goi', 'BR-GO', 0),
(249, 'BR', 'Maranhao', 'BR-MA', 0),
(250, 'BR', 'Mato Grosso', 'BR-MT', 0),
(251, 'BR', 'Mato Grosso do Sul', 'BR-MS', 0),
(252, 'BR', 'Minas Gerais', 'BR-MG', 0),
(253, 'BR', 'Par', 'BR-PA', 0),
(254, 'BR', 'Paraiba', 'BR-PB', 0),
(255, 'BR', 'Paran', 'BR-PR', 0),
(256, 'BR', 'Pernambuco', 'BR-PE', 0),
(257, 'BR', 'Piau', 'BR-PI', 0),
(258, 'BR', 'Rio de Janeiro', 'BR-RJ', 0),
(259, 'BR', 'Rio Grande do Norte', 'BR-RN', 0),
(260, 'BR', 'Rio Grande do Sul', 'BR-RS', 0),
(261, 'BR', 'Rondonia', 'BR-RO', 0),
(262, 'BR', 'Roraima', 'BR-RR', 0),
(263, 'BR', 'Santa Catarina', 'BR-SC', 0),
(264, 'BR', 'Sao Paulo', 'BR-SP', 0),
(265, 'BR', 'Sergipe', 'BR-SE', 0),
(266, 'BR', 'Tocantins', 'BR-TO', 0),
(267, 'CA', 'Alberta', 'CA-AB', 0),
(268, 'CA', 'British Columbia', 'CA-BC', 0),
(269, 'CA', 'Manitoba', 'CA-MB', 0),
(270, 'CA', 'New Brunswick', 'CA-NB', 0),
(271, 'CA', 'Newfoundland and Labrador', 'CA-NL', 0),
(272, 'CA', 'Northwest Territories', 'CA-NT', 0),
(273, 'CA', 'Nova Scotia', 'CA-NS', 0),
(274, 'CA', 'Nunavut', 'CA-NU', 0),
(275, 'CA', 'Ontario', 'CA-ON', 0),
(276, 'CA', 'Prince Edward Island', 'CA-PE', 0),
(277, 'CA', 'Quebec', 'CA-QC', 0),
(278, 'CA', 'Saskatchewan', 'CA-SK', 0),
(279, 'CA', 'Yukon', 'CA-YT', 0),
(280, 'ID', 'Aceh', 'ID-AC', 0),
(281, 'ID', 'Bali', 'ID-BA', 0),
(282, 'ID', 'Banten', 'ID-BT', 0),
(283, 'ID', 'Bengkulu', 'ID-BE', 0),
(284, 'ID', 'Gorontalo', 'ID-GO', 0),
(285, 'ID', 'Jakarta', 'ID-JK', 0),
(286, 'ID', 'Jambi', 'ID-JA', 0),
(287, 'ID', 'Jawa Barat', 'ID-JB', 0),
(288, 'ID', 'Jawa Tengah', 'ID-JT', 0),
(289, 'ID', 'Jawa Timur', 'ID-JI', 0),
(290, 'ID', 'Kalimantan Barat', 'ID-KB', 0),
(291, 'ID', 'Kalimantan Selatan', 'ID-KS', 0),
(292, 'ID', 'Kalimantan Tengah', 'ID-KT', 0),
(293, 'ID', 'Kalimantan Timur', 'ID-KI', 0),
(294, 'ID', 'Kalimantan Utara', 'ID-KU', 0),
(295, 'ID', 'Kepulauan Bangka Belitung', 'ID-BB', 0),
(296, 'ID', 'Kepulauan Riau', 'ID-KR', 0),
(297, 'ID', 'Lampung', 'ID-LA', 0),
(298, 'ID', 'Maluku', 'ID-MA', 0),
(299, 'ID', 'Maluku Utara', 'ID-MU', 0),
(300, 'ID', 'Nusa Tenggara Barat', 'ID-NB', 0),
(301, 'ID', 'Nusa Tenggara Timur', 'ID-NT', 0),
(302, 'ID', 'Papua', 'ID-PA', 0),
(303, 'ID', 'Papua Barat', 'ID-PB', 0),
(304, 'ID', 'Riau', 'ID-RI', 0),
(305, 'ID', 'Sulawesi Barat', 'ID-SR', 0),
(306, 'ID', 'Sulawesi Selatan', 'ID-SN', 0),
(307, 'ID', 'Sulawesi Tengah', 'ID-ST', 0),
(308, 'ID', 'Sulawesi Tenggara', 'ID-SG', 0),
(309, 'ID', 'Sulawesi Utara', 'ID-SA', 0),
(310, 'ID', 'Sumatera Barat', 'ID-SB', 0),
(311, 'ID', 'Sumatera Selatan', 'ID-SS', 0),
(312, 'ID', 'Sumatera Utara', 'ID-SU', 0),
(313, 'ID', 'Yogyakarta', 'ID-YO', 0),
(314, 'MX', 'Aguascalientes', 'MX-AG', 0),
(315, 'MX', 'Baja California Norte', 'MX-BC', 0),
(316, 'MX', 'Baja California Sur', 'MX-BS', 0),
(317, 'MX', 'Chihuahua', 'MX-CH', 0),
(318, 'MX', 'Colima', 'MX-CL', 0),
(319, 'MX', 'Campeche', 'MX-CM', 0),
(320, 'MX', 'Coahuila', 'MX-CO', 0),
(321, 'MX', 'Chiapas', 'MX-CS', 0),
(322, 'MX', 'Distrito Federal', 'MX-DF', 0),
(323, 'MX', 'Durango', 'MX-DG', 0),
(324, 'MX', 'Guerrero', 'MX-GR', 0),
(325, 'MX', 'Guanajuato', 'MX-GT', 0),
(326, 'MX', 'Hidalgo', 'MX-HG', 0),
(327, 'MX', 'Jalisco', 'MX-JA', 0),
(328, 'MX', 'Michoacan', 'MX-MI', 0),
(329, 'MX', 'Morelos', 'MX-MO', 0),
(330, 'MX', 'Nayarit', 'MX-NA', 0),
(331, 'MX', 'Nuevo Leon', 'MX-NL', 0),
(332, 'MX', 'Oaxaca', 'MX-OA', 0),
(333, 'MX', 'Puebla', 'MX-PU', 0),
(334, 'MX', 'Quintana Roo', 'MX-QR', 0),
(335, 'MX', 'Queretaro', 'MX-QT', 0),
(336, 'MX', 'Sinaloa', 'MX-SI', 0),
(337, 'MX', 'San Luis Potosi', 'MX-SL', 0),
(338, 'MX', 'Sonora', 'MX-SO', 0),
(339, 'MX', 'Tabasco', 'MX-TB', 0),
(340, 'MX', 'Tlaxcala', 'MX-TL', 0),
(341, 'MX', 'Tamaulipas', 'MX-TM', 0),
(342, 'MX', 'Veracruz', 'MX-VE', 0),
(343, 'MX', 'Yucatan', 'MX-YU', 0),
(344, 'MX', 'Zacatecas', 'MX-ZA', 0),
(345, 'US', 'Alaska', 'US-AK', 0),
(346, 'US', 'Alabama', 'US-AL', 0),
(347, 'US', 'American Samoa', 'US-AS', 0),
(348, 'US', 'Arizona', 'US-AZ', 0),
(349, 'US', 'Arkansas', 'US-AR', 0),
(350, 'US', 'California', 'US-CA', 0),
(351, 'US', 'Colorado', 'US-CO', 0),
(352, 'US', 'Connecticut', 'US-CT', 0),
(353, 'US', 'Delaware', 'US-DE', 0),
(354, 'US', 'District of Columbia', 'US-DC', 0),
(355, 'US', 'Florida', 'US-FL', 0),
(356, 'US', 'Georgia', 'US-GA', 0),
(357, 'US', 'Guam', 'US-GU', 0),
(358, 'US', 'Hawaii', 'US-HI', 0),
(359, 'US', 'Idaho', 'US-ID', 0),
(360, 'US', 'Illinois', 'US-IL', 0),
(361, 'US', 'Indiana', 'US-IN', 0),
(362, 'US', 'Iowa', 'US-IA', 0),
(363, 'US', 'Kansas', 'US-KS', 0),
(364, 'US', 'Kentucky', 'US-KY', 0),
(365, 'US', 'Louisiana', 'US-LA', 0),
(366, 'US', 'Maine', 'US-ME', 0),
(367, 'US', 'Marshall Islands', 'US-MH', 0),
(368, 'US', 'Maryland', 'US-MD', 0),
(369, 'US', 'Massachusetts', 'US-MA', 0),
(370, 'US', 'Michigan', 'US-MI', 0),
(371, 'US', 'Minnesota', 'US-MN', 0),
(372, 'US', 'Mississippi', 'US-MS', 0),
(373, 'US', 'Missouri', 'US-MO', 0),
(374, 'US', 'Montana', 'US-MT', 0),
(375, 'US', 'Nebraska', 'US-NE', 0),
(376, 'US', 'Nevada', 'US-NV', 0),
(377, 'US', 'New Hampshire', 'US-NH', 0),
(378, 'US', 'New Jersey', 'US-NJ', 0),
(379, 'US', 'New Mexico', 'US-NM', 0),
(380, 'US', 'New York', 'US-NY', 0),
(381, 'US', 'North Carolina', 'US-NC', 0),
(382, 'US', 'North Dakota', 'US-ND', 0),
(383, 'US', 'Northern Mariana Islands', 'US-MP', 0),
(384, 'US', 'Ohio', 'US-OH', 0),
(385, 'US', 'Oklahoma', 'US-OK', 0),
(386, 'US', 'Oregon', 'US-OR', 0),
(387, 'US', 'Palau', 'US-PW', 0),
(388, 'US', 'Pennsylvania', 'US-PA', 0),
(389, 'US', 'Puerto Rico', 'US-PR', 0),
(390, 'US', 'Rhode Island', 'US-RI', 0),
(391, 'US', 'South Carolina', 'US-SC', 0),
(392, 'US', 'South Dakota', 'US-SD', 0),
(393, 'US', 'Tennessee', 'US-TN', 0),
(394, 'US', 'Texas', 'US-TX', 0),
(395, 'US', 'Utah', 'US-UT', 0),
(396, 'US', 'Vermont', 'US-VT', 0),
(397, 'US', 'Virgin Islands', 'US-VI', 0),
(398, 'US', 'Virginia', 'US-VA', 0),
(399, 'US', 'Washington', 'US-WA', 0),
(400, 'US', 'West Virginia', 'US-WV', 0),
(401, 'US', 'Wisconsin', 'US-WI', 0),
(402, 'US', 'Wyoming', 'US-WY', 0),
(403, 'NG', 'Abia State', 'NG-AB', 0),
(404, 'NG', 'Adamawa State', 'NG-AD', 0),
(405, 'NG', 'Akwa Ibom State', 'NG-AK', 0),
(406, 'NG', 'Anambra State', 'NG-AN', 0),
(407, 'NG', 'Bauchi State', 'NG-BA', 0),
(408, 'NG', 'Bayelsa State', 'NG-BY', 0),
(409, 'NG', 'Benue State', 'NG-BE', 0),
(410, 'NG', 'Borno State', 'NG-BO', 0),
(411, 'NG', 'Cross River State', 'NG-CR', 0),
(412, 'NG', 'Delta State', 'NG-DE', 0),
(413, 'NG', 'Ebonyi State', 'NG-EB', 0),
(414, 'NG', 'Edo State', 'NG-ED', 0),
(415, 'NG', 'Ekiti State', 'NG-EK', 0),
(416, 'NG', 'Enugu State', 'NG-EN', 0),
(417, 'NG', 'FCT', 'NG-FC', 0),
(418, 'NG', 'Gombe State', 'NG-GO', 0),
(419, 'NG', 'Imo State', 'NG-IM', 0),
(420, 'NG', 'Jigawa State', 'NG-JI', 0),
(421, 'NG', 'Kaduna State', 'NG-KD', 0),
(422, 'NG', 'Kano State', 'NG-KN', 0),
(423, 'NG', 'Katsina State', 'NG-KT', 0),
(424, 'NG', 'Kebbi State', 'NG-KE', 0),
(425, 'NG', 'Kogi State', 'NG-KO', 0),
(426, 'NG', 'Kwara State', 'NG-KW', 0),
(427, 'NG', 'Lagos State', 'NG-LA', 0),
(428, 'NG', 'Nasarawa State', 'NG-NA', 0),
(429, 'NG', 'Niger State', 'NG-NI', 0),
(430, 'NG', 'Ogun State', 'NG-OG', 0),
(431, 'NG', 'Ondo State', 'NG-ON', 0),
(432, 'NG', 'Osun State', 'NG-OS', 0),
(433, 'NG', 'Oyo State', 'NG-OY', 0),
(434, 'NG', 'Plateau State', 'NG-PL', 0),
(435, 'NG', 'Rivers State', 'NG-RI', 0),
(436, 'NG', 'Sokoto State', 'NG-SO', 0),
(437, 'NG', 'Taraba State', 'NG-TA', 0),
(438, 'NG', 'Yobe State', 'NG-YO', 0),
(439, 'NG', 'Zamfara State', 'NG-ZA', 0),
(440, 'NN', 'Other', 'N/A', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bf_students`
--

CREATE TABLE IF NOT EXISTS `bf_students` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `matricNo` int(11) DEFAULT NULL,
  `jamb_reg` varchar(11) DEFAULT NULL,
  `prog_id` int(6) NOT NULL,
  `progLevel` int(6) NOT NULL,
  `studyMode` int(3) NOT NULL,
  `entryMode` int(3) NOT NULL,
  `created_on` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricNo` (`matricNo`),
  UNIQUE KEY `jamb_reg` (`jamb_reg`),
  KEY `user_id` (`user_id`),
  KEY `progLevel` (`progLevel`),
  KEY `studyMode` (`studyMode`),
  KEY `entryMode` (`entryMode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bf_students`
--

INSERT INTO `bf_students` (`id`, `user_id`, `matricNo`, `jamb_reg`, `prog_id`, `progLevel`, `studyMode`, `entryMode`, `created_on`, `deleted`, `status`) VALUES
(1, 2, 214123, 'de123456', 1, 1, 1, 1, '0000-00-00 00:00:00', 0, 1);

--
-- Triggers `bf_students`
--
DROP TRIGGER IF EXISTS `matric_to_usertable`;
DELIMITER //
CREATE TRIGGER `matric_to_usertable` AFTER INSERT ON `bf_students`
 FOR EACH ROW UPDATE bf_users
SET username = NEW.matricNo
WHERE bf_users.id = NEW.user_id
//
DELIMITER ;
DROP TRIGGER IF EXISTS `matric_to_usertable-2`;
DELIMITER //
CREATE TRIGGER `matric_to_usertable-2` AFTER UPDATE ON `bf_students`
 FOR EACH ROW UPDATE bf_users
SET bf_users.username = NEW.matricNo
WHERE bf_users.id = NEW.user_id
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `bf_studentview`
--
CREATE TABLE IF NOT EXISTS `bf_studentview` (
`student_id` int(9)
,`user_id` int(11)
,`matricNo` int(11)
,`jamb_reg` varchar(11)
,`level` int(6)
,`studyMode` int(3)
,`entryMode` int(3)
,`status` tinyint(1)
,`firstname` varchar(100)
,`middlename` varchar(100)
,`lastname` varchar(100)
,`prog_id` int(9)
,`programme` varchar(112)
,`duration` int(6)
,`deg_id` int(11)
,`course` varchar(100)
,`dept_id` int(9)
,`department` varchar(100)
,`fac_id` int(9)
,`faculty` varchar(100)
,`deleted` tinyint(1)
);
-- --------------------------------------------------------

--
-- Table structure for table `bf_subjectbank`
--

CREATE TABLE IF NOT EXISTS `bf_subjectbank` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `course_code` varchar(10) NOT NULL,
  `subject_title` varchar(150) NOT NULL,
  `unit` int(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text,
  `created_on` datetime NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `bf_subjectbank`
--

INSERT INTO `bf_subjectbank` (`id`, `course_code`, `subject_title`, `unit`, `user_id`, `description`, `created_on`, `modified_on`, `deleted`, `status`) VALUES
(1, 'CSC 101', 'Introduction to Computer Science', 2, 0, 'To be Completed', '2013-12-21 12:15:11', NULL, 0, 1),
(2, 'ENG 101', 'English Language I', 2, 1, 'To be Completed', '2013-12-22 12:15:11', '2014-02-06 15:20:27', 0, 1),
(3, 'ENG 103', 'Spoken English', 2, 0, 'To be Completed', '2013-12-23 12:15:11', NULL, 0, 1),
(4, 'ENG 121', 'Introduction to Nigerian Literature', 2, 0, 'To be Completed', '2013-12-24 12:15:11', NULL, 0, 1),
(5, 'ENG 123', 'Theater Workshop', 2, 0, 'To be Completed', '2013-12-25 12:15:11', NULL, 0, 1),
(6, 'TXN 101', 'Testing subject', 2, 0, 'To be completed', '2015-10-13 03:52:00', '2015-10-13 04:33:52', 0, 1);

-- --------------------------------------------------------
--
-- Table structure for table `bf_user_meta`
--

CREATE TABLE IF NOT EXISTS `bf_user_meta` (
  `meta_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) NOT NULL DEFAULT '',
  `meta_value` text,
  PRIMARY KEY (`meta_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `bf_user_meta`
--

INSERT INTO `bf_user_meta` (`meta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'dob', '1980-03-05'),
(3, 1, 'gender', 'Male'),
(4, 1, 'nationality', NULL),
(5, 1, 'marital_status', 'Married'),
(6, 1, 'health_status', 'Healthy'),
(7, 1, 'religion', 'Christian'),
(8, 2, 'dob', '1979-04-12'),
(10, 2, 'gender', 'Male'),
(11, 2, 'nationality', NULL),
(12, 2, 'marital_status', 'Married'),
(13, 2, 'health_status', 'Averagely Healthy'),
(14, 2, 'religion', 'Christian');

-- --------------------------------------------------------

--
-- Structure for view `bf_contacts_view`
--
DROP TABLE IF EXISTS `bf_contacts_view`;

CREATE ALGORITHM=MERGE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bf_contacts_view` AS select `bf_contact_address`.`id` AS `id`,`bf_contact_address`.`user_id` AS `user_id`,`bf_users`.`firstname` AS `firstname`,`bf_users`.`middlename` AS `middlename`,`bf_users`.`lastname` AS `lastname`,concat(`bf_users`.`firstname`,convert(space(1) using utf8),`bf_users`.`middlename`,convert(space(1) using utf8),`bf_users`.`lastname`) AS `fullname`,`bf_contact_address`.`street_line1` AS `street_line1`,`bf_contact_address`.`street_line2` AS `street_line2`,`bf_states`.`state_name` AS `state`,`bf_countries`.`printable_name` AS `country`,`bf_local_government`.`lga_name` AS `lga`,`bf_contact_address`.`postcode` AS `postcode`,`bf_contact_address`.`other` AS `other`,`bf_contact_address`.`telephone` AS `telephone`,`bf_contact_address`.`contact_type` AS `contact_type` from ((((`bf_contact_address` join `bf_users` on((`bf_users`.`id` = `bf_contact_address`.`user_id`))) join `bf_states` on((`bf_states`.`id` = `bf_contact_address`.`state_id`))) join `bf_countries` on((`bf_countries`.`iso` = `bf_states`.`country_code`))) join `bf_local_government` on((`bf_local_government`.`id` = `bf_contact_address`.`lga_id`)));

-- --------------------------------------------------------

--
-- Structure for view `bf_lga_view`
--
DROP TABLE IF EXISTS `bf_lga_view`;

CREATE ALGORITHM=MERGE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bf_lga_view` AS select `bf_local_government`.`id` AS `id`,`bf_local_government`.`lga_name` AS `lga_name`,`bf_local_government`.`literacy` AS `literacy`,`bf_states`.`state_name` AS `state`,`bf_countries`.`printable_name` AS `country`,`bf_local_government`.`deleted` AS `deleted` from ((`bf_local_government` join `bf_states` on((`bf_states`.`id` = `bf_local_government`.`state_id`))) join `bf_countries` on((`bf_countries`.`iso` = `bf_states`.`country_code`)));

-- --------------------------------------------------------

--
-- Structure for view `bf_studentview`
--
DROP TABLE IF EXISTS `bf_studentview`;

CREATE ALGORITHM=MERGE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bf_studentview` AS select `s`.`id` AS `student_id`,`s`.`user_id` AS `user_id`,`s`.`matricNo` AS `matricNo`,`s`.`jamb_reg` AS `jamb_reg`,`s`.`progLevel` AS `level`,`s`.`studyMode` AS `studyMode`,`s`.`entryMode` AS `entryMode`,`s`.`status` AS `status`,`u`.`firstname` AS `firstname`,`u`.`middlename` AS `middlename`,`u`.`lastname` AS `lastname`,`p`.`id` AS `prog_id`,concat(`dg`.`deg_Abbreviation`,convert(space(1) using utf8),`c`.`course_name`) AS `programme`,`p`.`duration` AS `duration`,`p`.`deg_id` AS `deg_id`,`c`.`course_name` AS `course`,`d`.`id` AS `dept_id`,`d`.`dept_name` AS `department`,`f`.`id` AS `fac_id`,`f`.`fac_name` AS `faculty`,`s`.`deleted` AS `deleted` from ((((((`bf_students` `s` join `bf_users` `u` on((`u`.`id` = `s`.`user_id`))) join `bf_program` `p` on((`p`.`id` = `s`.`prog_id`))) join `bf_degree` `dg` on((`dg`.`id` = `p`.`deg_id`))) join `bf_coursebank` `c` on((`c`.`id` = `p`.`course_id`))) join `bf_department` `d` on((`d`.`id` = `c`.`dept_id`))) join `bf_faculty` `f` on((`f`.`id` = `d`.`fac_id`)));

CREATE
    ALGORITHM = MERGE
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `bf_programme_view` AS
    SELECT
        `bf_programme`.`prog_id` AS `id`,
        CONCAT(`bf_degree`.`degreeAbbreviation`,
                CONVERT( SPACE(1) USING UTF8),
                `bf_coursebank`.`courseName`) AS `program`,
        `bf_department`.`dept_name` AS `department`,
        `bf_faculty`.`fac_name` AS `faculty`,
        `bf_programme`.`description` AS `description`,
        `bf_programme`.`studyTypeID` AS `studyTypeID`,
        `bf_programme`.`programmeCode` AS `programmeCode`,
        `bf_programme`.`startLevel` AS `startLevel`,
        `bf_programme`.`endLevel` AS `endlevel`,
        `bf_programme`.`deleted` AS `deleted`,
        `bf_programme`.`status` AS `status`
    FROM
        ((((`bf_programme`
        LEFT JOIN `bf_coursebank` ON ((`bf_coursebank`.`course_id` = `bf_programme`.`course_id`)))
        LEFT JOIN `bf_department` ON ((`bf_department`.`dept_id` = `bf_coursebank`.`dept_id`)))
        LEFT JOIN `bf_faculty` ON ((`bf_faculty`.`fac_id` = `bf_department`.`fac_id`)))
        LEFT JOIN `bf_degree` ON ((`bf_degree`.`deg_id` = `bf_programme`.`deg_id`)));


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
