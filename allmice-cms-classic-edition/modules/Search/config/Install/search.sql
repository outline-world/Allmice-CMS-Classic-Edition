-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2017 at 01:43 AM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `mod_search`
--

CREATE TABLE `mod_search` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL DEFAULT '',
  `description` varchar(500) NOT NULL DEFAULT '',
  `search_table_field` varchar(60) NOT NULL DEFAULT '',
  `search_table` varchar(60) NOT NULL DEFAULT '',
  `module_name` varchar(60) NOT NULL DEFAULT '',
  `uri` varchar(60) NOT NULL DEFAULT '',
  `title_table_field` varchar(60) NOT NULL DEFAULT '',
  `add_where_clause` varchar(255) NOT NULL DEFAULT '',
  `order_clause` varchar(255) NOT NULL DEFAULT '',
  `result_field_names` varchar(255) NOT NULL DEFAULT '',
  `result_field_titles` varchar(255) NOT NULL DEFAULT '',
  `language_code` varchar(15) NOT NULL DEFAULT 'en' COMMENT 'Two character code (ISO 639-1) or some other code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `mod_search`
--
ALTER TABLE `mod_search`
  ADD PRIMARY KEY (`id`);

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('Search', 'Form validation regular expression pattern for medium text fields (e.g. keywords for search).', 'mediumText', 'formValidationRegEx', '/^(.){0,120}$/'),
('Search', 'This configuration value determines, which search type will be used for search block. The value should be in format "table_name, field_name" to find the search type id.', 'searchType', 'searchBlock', 'mod_page, body'),
('Search', 'This configuration value determines, how the search result will be displayed in list. Possible values are table and list. Table is more traditional mode; list is more smart-device-friendly mode, where search result columns are displayed in rows.', 'listMode', 'searchResult', 'list'),
('Search', 'Custom file path to view Search module list-by-type method page. E.g. custom/templates/search/list-by-type.phtml. If this value is empty or the file does not exist, then no custom file will be used.', 'viewPath', 'listByTypeEvent', '');

INSERT INTO `core_language` (`language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
('en', 21, 'Search', 'indexEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Search', 'indexEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Search', 'indexEvent', 'guide/searchType', 'Choose the option, which explains what sort of data will be searched for.'),
('en', 21, 'Search', 'indexEvent', 'guide/searchPhrase', 'Write here the search phrase or keyword(s) which you wish to use by searching. By default space (" ") and characters "*" and "%" in the phrase will be used as wild characters to search for 0 or more not determined symbols (e.g. [keyword1 keyword2]). If you wish to find an exact phrase, i.e. to use space as part of the search phrase (not as wild character), then start and end the whole search phrase with (double) quotes (e.g. ["your exact search phrase"]).'),
('en', 21, 'Search', 'indexEvent', 'label/searchType', 'Search location:'),
('en', 21, 'Search', 'indexEvent', 'label/searchPhrase', 'Search phrase:'),
('en', 21, 'Search', 'indexEvent', 'value/search', 'Search'),
('en', 22, 'Search', 'indexEvent', 'message1', 'Total entries found: [noOfAllItems]'),
('en', 22, 'Search', 'indexEvent', 'message2', 'Current search result page: [curPage] of [allPages]'),
('en', 22, 'Search', 'indexEvent', 'message3', 'There is no search result.'),
('en', 22, 'Search', 'indexEvent', 'message4', 'There are no search options yet or search type id is not correct or you do not have access right for the content corresponding to this search type!'),
('en', 22, 'Search', 'indexEvent', 'tb1Title', 'List of Search result'),
('en', 22, 'Search', 'indexEvent', 'link1', 'Link'),
('en', 21, 'Search', 'listByTypeEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Search', 'listByTypeEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Search', 'listByTypeEvent', 'guide/searchPhrase', 'Use quotes to find content, which contains exact search phrase (e.g. ["your exact search phrase"]). Use no quotes to find content, which contains all the keywords in the order as they are on search field (e.g. [keyword1 keyword2]).'),
('en', 21, 'Search', 'listByTypeEvent', 'label/searchPhrase', 'Search phrase:'),
('en', 21, 'Search', 'listByTypeEvent', 'value/search', 'Search'),
('en', 22, 'Search', 'listByTypeEvent', 'message1', 'Total entries found: [noOfAllItems]'),
('en', 22, 'Search', 'listByTypeEvent', 'message2', 'Current search result page: [curPage] of [allPages]'),
('en', 22, 'Search', 'listByTypeEvent', 'message3', 'There is no search result.'),
('en', 22, 'Search', 'listByTypeEvent', 'message4', 'There are no search options yet or search type id is not correct or you do not have access right for the content corresponding to this search type!'),
('en', 22, 'Search', 'listByTypeEvent', 'tb1Title', 'List of Search result'),
('en', 22, 'Search', 'listByTypeEvent', 'link1', 'Link'),
('en', 22, 'Search', 'listByTypeEvent', 'noAccess', 'No Access'),
('en', 22, 'Search', 'indexEvent', 'link1label', 'Link'),
('en', 22, 'Search', 'indexEvent', 'link1text', 'Click here!'),
('en', 22, 'Search', 'listByTypeEvent', 'link1label', 'Link'),
('en', 22, 'Search', 'listByTypeEvent', 'link1text', 'Click here!');

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mod_search`
--
ALTER TABLE `mod_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
