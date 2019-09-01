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
-- Table structure for table `mod_global_observer_visitor`
--

CREATE TABLE `mod_visitor_archived_visitor` (
  `id` int(11) NOT NULL,
  `sess_id` varchar(32) NOT NULL DEFAULT '',
  `ip` varchar(32) NOT NULL DEFAULT '',
  `device_data` varchar(255) NOT NULL DEFAULT '',
  `other` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Possible values: 0 - consent unknown; 1 - consent signal registered; 2 - consent opt-out request.',
  `consent_type` tinyint(3) NOT NULL DEFAULT '2' COMMENT 'Consent type values: 1- using; 2- continuing; 3- submit.',
  `last_visit` int(11) NOT NULL DEFAULT '0' COMMENT 'Timestamp for easier backup and deleting purposes.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `mod_global_observer_location`
--

CREATE TABLE `mod_visitor_archived_location` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `mod_global_observer_event`
--

CREATE TABLE `mod_visitor_archived_event` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Possible values: 1 - url visit; 11 - consent signal by url visit; 1YX - consent signal by post submit (X is 0-9, Y is 0-4); 22 - consent opt-out post request.',
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------


--
-- Dumping data for table `core_misc_data`
--

INSERT INTO `core_misc_data` (`integer_value`, `module_name`, `uri`, `type`, `value`) VALUES
('0', 'Visitor', 'openedArchiveFile', 'listArchiveFilesEvent', '');


-- --------------------------------------------------------
--
-- Indexes for dumped tables
--

--
-- Indexes for table `mod_visitor_archived_visitor`
--
ALTER TABLE `mod_visitor_archived_visitor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_visitor_archived_location`
--
ALTER TABLE `mod_visitor_archived_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_visitor_archived_event`
--
ALTER TABLE `mod_visitor_archived_event`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mod_visitor_archived_visitor`
--
ALTER TABLE `mod_visitor_archived_visitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `mod_visitor_archived_location`
--
ALTER TABLE `mod_visitor_archived_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `mod_visitor_archived_event`
--
ALTER TABLE `mod_visitor_archived_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
