-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 11, 2017 at 04:41 AM
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
-- Table structure for table `mod_profile`
--

CREATE TABLE `mod_profile` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `avatar_type` varchar(30) NOT NULL DEFAULT '',
  `gravatar_source` varchar(125) NOT NULL DEFAULT '',
  `avatar_url` varchar(255) NOT NULL DEFAULT '',
  `personal_notes` varchar(2040) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mod_profile`
--

INSERT INTO `mod_profile` (`user_id`, `avatar_type`, `gravatar_source`, `avatar_url`, `personal_notes`) VALUES
(0, 'mm', '', 'https://www.gravatar.com/avatar/3ca1cb011deb450febc793032cf5e29a?s=40&d=mm&r=g', ''),
(1, 'allmice', '', 'misc/input/allmice40.png', '');

-- --------------------------------------------------------

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('Profile', 'Form validation regular expression pattern for e-mail fields.', 'email', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
('Profile', 'Form validation regular expression pattern for human readable medium text fields (maximum 250 characters).', 'text250', 'formValidationRegEx', '/^(.){0,250}$/'),
('Profile', 'Size of the image in pixels (width and height equal) for gravatar or sitewide avatar images.', 'avatarImageSize', 'indexEvent', '40'),
('Profile', 'Url for sitewide avatar image.', 'siteAvatarUrl', 'indexEvent', 'misc/input/allmice40.png'),
('Profile', 'Activate (on) or deactivate (off) the option, whether registered user can choose default language.', 'languageSwitch', 'indexEvent', 'off'),
('Profile', 'Default language, which will be associated with a registered user profile by default if user will not choose it.', 'defaultLanguage', 'indexEvent', 'en');

INSERT INTO `core_language` (`language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
('en', 21, 'Profile', 'indexEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Profile', 'indexEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Profile', 'indexEvent', 'guide/gravatarSource', 'Change the case (capital or lower case) of the letters of your email address and click Refresh images to get different avatar images. Gravatar service is used to compose most of the images - see https://en.gravatar.com/.'),
('en', 21, 'Profile', 'indexEvent', 'guide/personalNotes', 'You can write and keep here some personal notes - up to 2040 characters.'),
('en', 21, 'Profile', 'indexEvent', 'label/gravatarSource', 'Gravatar source'),
('en', 21, 'Profile', 'indexEvent', 'label/personalNotes', 'Personal notes'),
('en', 21, 'Profile', 'indexEvent', 'value/refreshImages', 'Refresh images'),
('en', 21, 'Profile', 'indexEvent', 'value/getEmailAddress', 'Get email address'),
('en', 21, 'Profile', 'indexEvent', 'value/save', 'Save'),
('en', 22, 'Profile', 'indexEvent', 'message1', 'Avatar image source must be your email address!'),
('en', 22, 'Profile', 'indexEvent', 'message2', 'User id is not correct!'),
('en', 22, 'Profile', 'indexEvent', 'imageSetLabel', 'Avatar image'),
('en', 22, 'Profile', 'indexEvent', 'title', 'User Profile'),
('en', 21, 'Profile', 'indexEvent', 'label/langCode', 'Default language'),
('en', 21, 'Profile', 'indexEvent', 'guide/langCode', 'This default language may be used, if system decides in what language to send automated messages without any other information, what language would user prefer.');

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
