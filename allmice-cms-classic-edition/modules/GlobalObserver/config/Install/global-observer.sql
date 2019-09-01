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

CREATE TABLE `mod_global_observer_visitor` (
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

CREATE TABLE `mod_global_observer_location` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `mod_global_observer_event`
--

CREATE TABLE `mod_global_observer_event` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Possible values: 1 - url visit; 11 - consent signal by url visit; 1YX - consent signal by post submit (X is 0-9, Y is 0-4); 22 - consent opt-out post request.',
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('GlobalObserver', 'Module switch, which allows to switch all observing functionality on or off. Possible values are "on" or "off".', 'moduleSwitch', 'general', 'off'),
('GlobalObserver', 'Consent signal getting method. Possible values are: using, continuing and submit. Caution: Archive existing data before changing this value!', 'consentMethod', 'consent', 'using'),
('GlobalObserver', 'Determines the method, how many times maximally browsing clicks will be saved into database and how many times message box will be shown, as long as message submit button has not been clicked. Possible values are notLimited and xTimes.', 'observingMethod', 'general', 'xTimes'),
('GlobalObserver', 'Determines the integer value, how many times maximally browsing clicks will be saved into database and how many times message box will be shown. This integer number will be used for counting, if observingMethod value is xTimes.', 'observingTimes', 'general', '5'),
('GlobalObserver', 'Parts of exceptional website addresses, separated by ;. The pages with a such url part, are considered as precondition for consent signal (not as part of giving consent). E.g. Reading Privacy Policy page can be a precondition before giving consent.', 'exUrlParts', 'general', '/terms;/contact;/opt-out-data;/privacy-and-cookies-policy'),
('GlobalObserver', 'Time unit. Possible values are: days, hours, minutes or seconds.', 'timeUnit', 'dataExpiry', 'days'),
('GlobalObserver', 'Time period (see also timeUnit), which determines, how often to delete older data. If value is 0, then never.', 'deletingFrequency', 'dataExpiry', '30'),
('GlobalObserver', 'Data expiring period for deleting (see also timeUnit), which determines, how old is data considered to be to delete it.', 'deletingExpiringPeriod', 'dataExpiry', '30'),
('GlobalObserver', 'Time period (see also timeUnit), which determines, how often to archive older data. If value is 0, then never.', 'archivingFrequency', 'dataExpiry', '30'),
('GlobalObserver', 'Data expiring period for archiving (see also timeUnit), which determines, how old is data considered to be to archived.', 'archivingExpiringPeriod', 'dataExpiry', '30'),
('GlobalObserver', 'Archiving location for older data. Provide a folder path and make sure, that this folder is writable for the web server software. If there is no value, then archiving will not be done.', 'archivingLocation', 'dataExpiry', ''),
('GlobalObserver', 'Observing will not be used for users with roles listed here. Separate the exceptional roles by commas and spaces. E.g. "admin, authenticated".', 'exceptionalRoles', 'general', 'admin'),
('GlobalObserver', 'Names of submit buttons, which will give consent signals. Commas and spaces are separating names. E.g. "mesSubmit, register". By clicking such button, an entry will be recorded into event table usually with type 10X, where X is 0-9, order of the name.', 'consentSubmitButtons', 'consent', 'mesSubmit, register'),
('GlobalObserver', 'Relative URL for Read more link, where Privacy Policy, use of cookies and other terms of use are described in more detail.', 'readMoreUrl', 'consent', '/terms');

--
-- Dumping data for table `core_misc_data`
--

INSERT INTO `core_misc_data` (`integer_value`, `module_name`, `uri`, `type`, `value`) VALUES
('0', 'GlobalObserver', 'lastDeletingTime', 'indexEvent', '0'),
('0', 'GlobalObserver', 'lastBackupTime', 'indexEvent', '0');


--
-- Dumping data for table `core_language`
--

INSERT INTO `core_language` (`language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
('en', 11, 'GlobalObserver', 'consentBlock', 'consentMessage1', 'This website uses cookies to ensure you get the best experience on our website. By using our website, you acknowledge that you understand and agree with our Privacy and Cookies Policy and other terms.'),
('en', 11, 'GlobalObserver', 'consentBlock', 'consentMessage2', ''),
('en', 11, 'GlobalObserver', 'consentBlock', 'consentButton1', 'Got it'),
('en', 11, 'GlobalObserver', 'consentBlock', 'consentLink1', 'More info');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mod_global_observer_visitor`
--
ALTER TABLE `mod_global_observer_visitor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_global_observer_location`
--
ALTER TABLE `mod_global_observer_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_global_observer_event`
--
ALTER TABLE `mod_global_observer_event`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mod_global_observer_visitor`
--
ALTER TABLE `mod_global_observer_visitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `mod_global_observer_location`
--
ALTER TABLE `mod_global_observer_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `mod_global_observer_event`
--
ALTER TABLE `mod_global_observer_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
