-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2018 at 12:00 AM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amc_test3`
--

-- --------------------------------------------------------

--
-- Table structure for table `am3_mod_language`
--

CREATE TABLE `mod_language` (
  `id` tinyint(3) NOT NULL,
  `language_code` varchar(15) NOT NULL DEFAULT '' COMMENT 'Usually two digit ISO 639-1 Language Code for html tags.',
  `language_code2` varchar(15) NOT NULL DEFAULT '' COMMENT 'Other more specific language code to separate different language versions. E.g. IETF code en-GB for British English.',
  `label` varchar(60) NOT NULL DEFAULT 'English' COMMENT 'Language option as user sees it. E.g. Deutsch for German.',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'The status value determines, whether to show this language as option in drop-down menus or elsewhere. Possible values are 0 or 1, meaning passive (0) or active (1).',
  `direction` varchar(8) NOT NULL DEFAULT 'ltr' COMMENT 'Language writing direction. Possible values are ltr (default) and rtl meaning left to right and right to left correspondingly.',
  `date_format` varchar(15) NOT NULL DEFAULT 'd/m/Y' COMMENT 'Date format according to this language for the cases, if only date is needed to display, but not specific time (see also timeFormat). See http://php.net/manual/en/datetime.formats.date.php.',
  `time_format` varchar(30) NOT NULL DEFAULT 'd/m/Y H:i' COMMENT 'Time format according to this language (see also dateFormat). See http://php.net/manual/en/datetime.formats.date.php.',
  `number_format` varchar(15) NOT NULL DEFAULT '#2#.' COMMENT 'Number format for the language in form: thousandsSeparator#decimals#decimalPoint. Part decimals specifies how many decimals. Part decimalPoint specifies what string to use for decimal point. Part thousandsSeparator specifies what string to use for thousands separator. If this value is empty, then the default will be used \'#2#.\'.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `am3_mod_language_relation`
--

CREATE TABLE `mod_language_item` (
  `id` int(11) NOT NULL,
  `parent_item_id` int(11) NOT NULL DEFAULT '1',
  `child_item_id` int(11) NOT NULL DEFAULT '1',
  `module_name` varchar(30) NOT NULL DEFAULT 'Page',
  `type` varchar(30) NOT NULL DEFAULT 'page' COMMENT 'If a module has many db. tables with multilingual text, then type field helps to separate the tables (e.g.: menu and menu_item).',
  `path` varchar(60) NOT NULL DEFAULT 'page/view',
  `language_code` varchar(15) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mod_language`
--

INSERT INTO `mod_language` (`id`, `language_code`, `language_code2`, `label`, `direction`, `status`) VALUES
('1', 'en', 'en', 'English', 'ltr', '1');

--
-- Indexes for dumped tables
--

INSERT INTO `core_language` (`language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
('en', 11, 'Language', 'setChooserBlock:langOptions', 'title', 'Language Picker'),
('en', 11, 'Language', 'setChooserBlock:langOptions', 'label1', 'Active language is:'),
('en', 11, 'Language', 'setChooserBlock:langOptions', 'label2', 'Choose another language:'),
('en', 11, 'Language', 'setChooserBlock:langLink', 'buttonStart1', 'Change language');

--
-- Indexes for table `mod_language`
--
ALTER TABLE `mod_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_language_item`
--
ALTER TABLE `mod_language_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mod_language`
--
ALTER TABLE `mod_language`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mod_language_item`
--
ALTER TABLE `mod_language_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
