-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2017 at 12:17 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amc_test1`
--

-- --------------------------------------------------------

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('FormField', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
('FormField', 'Form validation regular expression pattern for human readable medium text fields (maximum 250 characters).', 'text250', 'formValidationRegEx', '/^(.){0,250}$/'),
('FormField', 'Form validation regular expression pattern for tiny integer text fields (e.g. rank number for sorting purposes).', 'tinyInt', 'formValidationRegEx', '/^(.){0,3}$/');

-- --------------------------------------------------------

--
-- Table structure for table `am1_mod_form_field`
--

CREATE TABLE `mod_form_field` (
  `id` int(11) NOT NULL,
  `module` varchar(30) NOT NULL DEFAULT '',
  `event` varchar(30) NOT NULL DEFAULT '',
  `field_name` varchar(30) NOT NULL DEFAULT '',
  `visibility` varchar(30) NOT NULL DEFAULT 'visible' COMMENT 'visible/hidden',
  `required` varchar(30) NOT NULL DEFAULT 'false' COMMENT 'true/false',
  `field_order` tinyint(3) NOT NULL DEFAULT '0',
  `default_value` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `am1_mod_form_field`
--
ALTER TABLE `mod_form_field`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mod_form_field`
--
ALTER TABLE `mod_form_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
