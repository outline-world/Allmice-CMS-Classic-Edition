-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2016 at 02:11 AM
-- Server version: 5.7.15-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `mod_menu`
--

CREATE TABLE `mod_menu` (
  `id` int(11) NOT NULL,
  `code` varchar(60) NOT NULL COMMENT 'Id code for computer purposes',
  `title` varchar(60) NOT NULL COMMENT 'Human readable header',
  `type` tinyint(3) NOT NULL COMMENT '10-19: Horizontal; 20-29: Vertical',
  `status` tinyint(3) NOT NULL COMMENT '0- Passive; 1- Active',
  `creator_id` mediumint(7) NOT NULL COMMENT 'Creator (owner) id',
  `editor_id` mediumint(7) NOT NULL COMMENT 'Editor (last modifier) id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mod_menu_item`
--

CREATE TABLE `mod_menu_item` (
  `id` mediumint(7) NOT NULL,
  `menu_id` smallint(5) NOT NULL,
  `parent_id` mediumint(7) NOT NULL,
  `label` varchar(60) NOT NULL,
  `uri` varchar(60) NOT NULL,
  `depth` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Depth=Level of current menu item',
  `weight` smallint(5) NOT NULL DEFAULT '1' COMMENT '(Obsolete - likely not in use after last dev and order_code is used instead - Last digit of item_level?)',
  `order_code` varchar(60) NOT NULL DEFAULT '' COMMENT 'Determines order of the items in menu',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0- Passive; 1- Active',
  `has_children` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0- No children; 1- Has children',
  `creator_id` mediumint(7) NOT NULL COMMENT 'Creator (owner) id',
  `editor_id` mediumint(7) NOT NULL COMMENT 'Editor (last modifier) id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('Menu', 'Form validation regular expression pattern for tiny integer text fields (e.g. rank number for sorting purposes).', 'tinyInt', 'formValidationRegEx', '/^[0-9]{0,3}$/'),
('Menu', 'Form validation regular expression pattern for unique resource identifier (uri) text fields (e.g. small path or just an unique code).', 'uri', 'formValidationRegEx', '/^(.*)$/'),
('Menu', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
('Menu', 'Form validation regular expression pattern for human readable short text fields.', 'text60', 'formValidationRegEx', '/^(.){0,60}$/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mod_menu`
--
ALTER TABLE `mod_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_menu_item`
--
ALTER TABLE `mod_menu_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mod_menu`
--
ALTER TABLE `mod_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `mod_menu_item`
--
ALTER TABLE `mod_menu_item`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
