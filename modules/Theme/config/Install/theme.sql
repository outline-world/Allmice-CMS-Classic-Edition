-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2017 at 11:40 AM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

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
-- Dumping data for table `core_language`
--

INSERT INTO `core_language` (`language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
('en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeName', 'Theme name'),
('en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeTitle', 'Theme title'),
('en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeDesc', 'Theme description'),
('en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeVersion', 'Theme version'),
('en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeTime', 'Theme release time'),
('en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeDeveloper', 'Theme developer'),
('en', 22, 'Theme', 'installThemesEvent', 'title', 'Install Themes'),
('en', 22, 'Theme', 'installThemesEvent', 'link1', 'Administrator menu'),
('en', 22, 'Theme', 'installThemesEvent', 'tb1Title', 'Uninstalled themes'),
('en', 22, 'Theme', 'installThemesEvent', 'tb2Title', 'Installed themes'),
('en', 22, 'Theme', 'installThemesEvent', 'text1NoUninsThemes', 'There are no uninstalled themes.'),
('en', 22, 'Theme', 'installThemesEvent', 'text2NoInsThemes', 'There are no installed themes.'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeName', 'Theme name'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeTitle', 'Theme title'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeDesc', 'Theme description'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeVersion', 'Theme version'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeTime', 'Theme release time'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeDeveloper', 'Theme developer'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'title', 'Uninstall themes'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'link1', 'Administrator menu'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'tb1Title', 'Uninstalled themes'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'tb2Title', 'Installed themes'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'text1NoUninsThemes', 'There are no uninstalled themes.'),
('en', 22, 'Theme', 'uninstallThemesEvent', 'text2NoInsThemes', 'There are no installed themes.');

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('Theme', 'Default script tags for html head element in case of Theme module events. If place holder [none] is used, then this tag will be omitted.', 'default', 'headTags', '<script src=\"http://code.jquery.com/jquery-3.4.1.slim.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"[baseUrl]/modules/Theme/config/vendor/tinyColorPicker/colors.js\"></script>\r\n<script type=\"text/javascript\" src=\"[baseUrl]/modules/Theme/config/vendor/tinyColorPicker/jqColorPicker.js\"></script>\r\n');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
