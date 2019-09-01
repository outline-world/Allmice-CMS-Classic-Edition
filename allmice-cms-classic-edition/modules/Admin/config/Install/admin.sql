-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2017 at 08:32 AM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

-- --------------------------------------------------------

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('Admin', 'Form validation regular expression pattern for tiny integer text fields (e.g. rank number for sorting purposes).', 'tinyInt', 'formValidationRegEx', '/^[0-9]{0,3}$/'),
('Admin', 'Form validation regular expression pattern for unique resource identifier (uri) text fields (e.g. small path or just an unique code).', 'uri', 'formValidationRegEx', '/^[a-zA-Z0-9_\\-\\/]{0,60}$/'),
('Admin', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
('Admin', 'Form validation regular expression pattern for path text fields (e.g. url or some other long path).', 'path', 'formValidationRegEx', '/^[a-zA-Z0-9_\\-\\/]{0,255}$/'),
('Admin', 'Form validation regular expression pattern for small textarea fields (e.g. menu title for human).', 'smallTextarea', 'formValidationRegEx', '/^(.){0,510}$/'),
('Admin', 'Form validation regular expression pattern for medium textarea fields (e.g. description).', 'mediumTextarea', 'formValidationRegEx', '/^(.){0,2000}$/s'),
('Admin', 'Form validation regular expression pattern for username fields.', 'username', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,60}$/'),
('Admin', 'Form validation regular expression pattern for password fields.', 'password', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,255}$/'),
('Admin', 'Form validation regular expression pattern for e-mail fields.', 'email', 'formValidationRegEx', '/^(.+@.+\..+){0,120}$/');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
