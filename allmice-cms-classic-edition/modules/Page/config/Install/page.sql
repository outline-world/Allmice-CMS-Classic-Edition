-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2016 at 02:10 AM
-- Server version: 5.7.15-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

-- --------------------------------------------------------

--
-- Table structure for table `mod_page`
--

CREATE TABLE `mod_page` (
  `id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  `body` longtext NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Publishing permission: 0- None; 1- Published; 2- Unpublished',
  `created` int(11) NOT NULL,
  `edited` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL COMMENT 'Creator (owner) id',
  `editor_id` int(11) NOT NULL COMMENT 'Editor (last modifier) id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `mod_page_post`
--

CREATE TABLE `mod_page_post` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `origin_id` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `editor_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL DEFAULT '',
  `creator_name` varchar(60) NOT NULL DEFAULT '',
  `content` varchar(2000) NOT NULL DEFAULT '',
  `type` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '2' COMMENT 'Publishing permission: 0- None; 1- Published; 2- Unpublished',
  `time_created` int(11) NOT NULL DEFAULT '0',
  `time_edited` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `mod_page_snippet`
--

CREATE TABLE `mod_page_snippet` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL DEFAULT '0',
  `uri` varchar(60) NOT NULL DEFAULT '',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Snippet type: 1- plain text; 2- php code result from class, which location is in content field',
  `content` varchar(2000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('Page', 'Default script tags for html head element in case of Page module events.', 'default', 'headTags', '<script type="text/javascript" src="[baseUrl]/core/View/jquery-3.4.1.slim.min.js"></script>\r\n<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>\r\n<script src="[baseUrl]/modules/Page/config/vendor/ckeditor/ckeditor.js"></script>\r\n<script type="text/javascript">\r\n$(document).ready(function(){\r\n \r\n	$(".slidingDiv").show();\r\n	$(".show_hide").show();\r\n	 \r\n	$(\'.show_hide\').click(function(){\r\n		$(".slidingDiv").slideToggle();\r\n	});\r\n \r\n});\r\n</script>\r\n'),
('Page', 'Default script tags for html head element in case of Page module view event. If place holder [none] is used, then this tag will be omitted', 'view', 'headTags', '[none]'),
('Page', 'If set, then finds class and method, that will be used to build front page.', 'modules/Page/Model/FrontPage.php', 'frontPage', 'FrontPage/buildFrontPage/1'),
('Page', 'Template (html code with placeholders), that determines, which components of the Page module regular page will be displayed and how.', 'pageView', 'viewTemplate', '[pdfData][editorData]<h1>[title]</h1>\r\n<div class="content-body">\r\n[body]\r\n</div>'),
('Page', 'Template (html code with placeholders), that determines, which components of the Page module front page will be displayed and how.', 'frontpageView', 'viewTemplate', '<div class="content-body">\r\n[body]\r\n</div>'),
('Page', 'Form validation regular expression pattern for email fields.', 'email', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
('Page', 'Form validation regular expression pattern for short text fields (e.g. page title for human).', 'shortText', 'formValidationRegEx', '/^(.){0,60}$/'),
('Page', 'Form validation regular expression pattern for small textarea fields (e.g. menu title for human).', 'smallTextarea', 'formValidationRegEx', '/^(.){0,250}$/'),
('Page', 'Form validation regular expression pattern for medium textarea fields (e.g. post submitting field).', 'mediumTextarea', 'formValidationRegEx', '/^(.){0,2040}$/s'),
('Page', 'Form validation regular expression pattern for large textarea fields (e.g. page body textarea).', 'largeTextarea', 'formValidationRegEx', '/^(.){0,1000000}$/s'),
('Page', 'Form validation regular expression pattern for path text fields (e.g. url or some other long path).', 'path', 'formValidationRegEx', '/^[a-zA-Z0-9_\\-\\/]{0,255}$/'),
('Page', 'Form validation regular expression pattern for small integer text fields (e.g. rank number for sorting purposes).', 'smallInt', 'formValidationRegEx', '/^[0-9]{0,5}$/'),
('Page', 'Form validation regular expression pattern for captcha text fields.', 'captcha', 'formValidationRegEx', '/^[a-zA-Z0-9]{0,10}$/'),
('Page', 'Inside snippet switch. Possible values on or off. Determines whether to look for snippet entries from database or not.', 'insideSnippetSwitch', 'viewEvent', 'off'),
('Page', 'Comment (post) switch. Possible values are on or off. Determines whether to look for posts (comments) from database or not.', 'commentSwitch', 'viewEvent', 'off'),
('Page', 'Location of the class, which will be used to add the posts to a specific page.', 'postClassLocation', 'viewEvent', 'modules/Page/Model/Post.php'),
('Page', 'Activate (on) or deactivate (off) the option, whether page creator or owner can choose role access right by adding a new page.', 'roleAccessSwitch', 'addPageEvent', 'off'),
('Page', 'Default roles, which will have access right for the new page. E.g. &quot;admin, authenticated&quot;. If role access form element is enabled (see roleAccessSwitch), then these roles are selected by default in this element.', 'defaultRoleAccess', 'addPageEvent', 'admin, authenticated'),
('Page', 'Activate (on) or deactivate (off) the option, whether page creator or owner can choose role based caching by adding a new page.', 'roleCacheSwitch', 'addPageEvent', 'off'),
('Page', 'Default roles, for which the new page will be cached. E.g. &quot;admin, authenticated&quot; or empty if no roles chosen. If role caching form element is enabled (see roleCacheSwitch), then these roles are selected by default in this element.', 'defaultRoleCache', 'addPageEvent', ''),
('Page', 'Activate (on) or deactivate (off) the option, whether page creator or owner can choose bot tag by adding a new page.', 'botTagSwitch', 'addPageEvent', 'off'),
('Page', 'Default html bot tag integer identifier value. Possible values are between 1 to 5 meaning following: 1. No tag (html default - index, follow) 2. Noindex, nofollow 3. Noindex, follow 4. Index, nofollow, 5. Index, follow (with tag). If bot tag element is enabled (see botTagSwitch), then this value is selected by default in this element.', 'defaultBotTag', 'addPageEvent', '1'),
('Page', 'Roles, which can add comments to pages, if comment (post) switch is turned on.', 'commentRoleAccess', 'viewEvent', 'admin, authenticated'),
('Page', 'Template (html code with placeholders), that determines, which components of every Post item will be displayed and how.', 'postItemView', 'postTemplate', '&lt;div class=&quot;post-creating-data&quot;&gt;\r\n[creatorLabel] \r\n&lt;div class=&quot;post-creator-name&quot;&gt;\r\n[gravatar]\r\n[creatorName]\r\n&lt;/div&gt;\r\n&lt;div class=&quot;post-creating-time&quot;&gt;\r\n[creatingTime]\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n[editDataStart]\r\n&lt;div class=&quot;post-editing-data&quot;&gt;\r\n[editorLabel] \r\n&lt;div class=&quot;post-editor-name&quot;&gt;\r\n[editorName]\r\n&lt;/div&gt;\r\n&lt;div class=&quot;post-editing-time&quot;&gt;\r\n[editingTime]\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n[editDataEnd]\r\n&lt;div class=&quot;post-content&quot;&gt;\r\n[content]\r\n&lt;/div&gt;\r\n[editLink]\r\n'),
('Page', 'Settings to customize the pdf output of the third party PHP library (TCPDF). These settings are relevant, if config entry headerFooterDisplayMode value is Tcpdf. Some of these settings will also be used as default, when that mode is HtmlCss (the styles config entries in such mode would overwrite the default settings here). These settings are lines of key value pairs separated by equal sign (=) and are helping easier to integrate TCPDF library with Allmice CMS.', 'tcpdfVariousSettings', 'viewPdfEvent', 'fontFamily=helvetica\r\nfontStyle=\r\nfontSize=10\r\ntopMargin=32\r\ntopMargin=26\r\nbottomMargin=16\r\nleftMargin=15\r\nrightMargin=15\r\nheaderLogoFormat=PNG\r\nheaderLogoWidth=10\r\nheaderLogoHorizontalAlign=L\r\nheaderLogoVerticalAlign=M\r\nheaderLogoPath=misc/input/allmice80.png\r\nheaderLogoLeft=0\r\nheaderLogoTop=6\r\nheaderFontFamily=helvetica\r\nheaderFontStyle=\r\nheaderFontSize=14\r\nheaderTextCellWidth=0\r\nheaderTextCellHeight=20\r\nheaderTextHorizontalAlign=C\r\nheaderTextVerticalAlign=M\r\nheaderCellVerticalAlign=M\r\nheaderPositionFromTop=10\r\nheaderPositionFromTop=5\r\nheaderPositionFromLeft=0\r\nfooterFontFamily=helvetica\r\nfooterFontStyle=\r\nfooterFontSize=10\r\nfooterTextCellWidth=0\r\nfooterTextCellHeight=10\r\nfooterTextHorizontalAlign=C\r\nfooterTextVerticalAlign=T\r\nfooterCellVerticalAlign=M\r\nfooterPositionFromBottom=-5\r\nfooterPositionFromBottom=-15\r\nfooterPositionFromLeft=0\r\nspacesBeforeFooter=6\r\n'),
('Page', 'Path to header logo image file for pdf pages. E.g. misc/input/allmice80.png. This config entry is relevant if display mode is HtmlCss. If display mode is Tcpdf, then header logo file path should be found from config entry tcpdfVariousSettings.', 'logoPath', 'viewPdfEvent', 'misc/input/allmice80.png'),
('Page', 'Header styles for pdf pages, if headerFooterDisplayMode value is HtmlCss.', 'headerStyles', 'viewPdfEvent', '<style>\r\ntd {\r\n	align: center;\r\n}\r\n.image-cell {\r\n	background-color: #FFFFFF;\r\n	width: 40px;\r\n}\r\n.text-cell {\r\n	width: auto;\r\n	text-align: center;\r\n	background-color: #FFFFFF;\r\n	line-height: 40px;\r\n}\r\n\r\ntable.header-table {\r\n    border-bottom: 1px solid #49758a;\r\n    border-spacing: 4px;\r\n}\r\n\r\n</style>\r\n'),
('Page', 'Header HTML code for pdf pages, if headerFooterDisplayMode value is HtmlCss.', 'headerHtml', 'viewPdfEvent', '<table class=\"header-table\">\r\n<tr>\r\n[logoCode]\r\n<td class=\"text-cell\">\r\n[title]\r\n</td>\r\n</tr>\r\n</table>'),
('Page', 'HTML as content of place holder [logoCode] in headerHtml configuration entry for displaying logo image on pdf pages. If you wish not to display any logo image with corresponding HTML code, then leave this configuration value empty.', 'logoCode', 'viewPdfEvent', '&lt;td class=&quot;image-cell&quot;&gt;\r\n&lt;img src=&quot;[logoPath]&quot; height=&quot;40&quot; width=&quot;40&quot; /&gt;\r\n&lt;/td&gt;'),
('Page', 'Footer styles for pdf pages, if headerFooterDisplayMode value is HtmlCss.', 'footerStyles', 'viewPdfEvent', '<style>\r\ntd {\r\n	align: center;\r\n}\r\n.image-cell {\r\n	width: 40px;\r\n	background-color: #FFFFFF;\r\n}\r\n.text-cell {\r\n	width: auto;\r\n	text-align: center;\r\n	line-height: 40px;\r\n	background-color: #FFFFFF;\r\n}\r\n\r\ntable.footer-table {\r\n}\r\n\r\n</style>\r\n'),
('Page', 'Footer HTML code for pdf pages, if headerFooterDisplayMode value is HtmlCss.', 'footerHtml', 'viewPdfEvent', '<table class=\"footer-table\">\r\n<tr>\r\n<td style=\"width:9%;\">\r\n</td>\r\n<td class=\"text-cell\">\r\n[footerText] [currentPage]/[allPages]\r\n</td>\r\n<td style=\"width:9%;\">\r\n</td>\r\n</tr>\r\n</table>\r\n'),
('Page', 'Determines the way, how header and footer are displayed. Possible values are HtmlCss or Tcpdf or off (HtmlCss by any other value). Value off means, that no header nor footer will be used. Tcpdf mode: some of the TCPDF library&#39;s own methods will be used to display header and footer (see also config entry: tcpdfVariousSettings). HtmlCss mode: header and footer will be generated using HTML and CSS (see also: tcpdfVariousSettings, footerHtml, footerStyles, headerHtml, headerStyles, logoCode, logoPath).', 'headerFooterDisplayMode', 'viewPdfEvent', 'HtmlCss'),
('Page', 'Main styles for pdf pages.', 'mainStyles', 'viewPdfEvent', '<style>\r\n\r\n* {\r\n	margin: 0;\r\n	padding: 0;\r\n	color: #000000;\r\n	line-height: 1.5;\r\n	font: normal 12pt Verdana, sans-serif;\r\n}\r\n\r\na {\r\n	text-decoration:none;\r\n	color: #024;\r\n	padding: 8px;\r\n	line-height: 1.2;\r\n}\r\n\r\nh1 {\r\n	color: navy;\r\n	font-family: times;\r\n	font-size: 24pt;\r\n	text-decoration: underline;\r\n}\r\n\r\ntable, th, td {\r\n	border: 1px solid #49758a;\r\n	border-spacing: 0px;\r\n}\r\n\r\nth {\r\n	margin:0px;\r\n	padding: 2px;\r\n	border-top: 2px solid #29556a;\r\n	border-bottom: 2px solid #29556a;\r\n	border-left: 1px solid #49758a;\r\n	border-right: 1px solid #49758a;\r\n}\r\n\r\ntd {\r\n	margin:2px;\r\n	padding: 2px;\r\n}\r\n\r\ntable.no-border, td.no-border {\r\n	border: 0px solid white;\r\n}\r\n\r\ntd.number {\r\n	text-align: right;\r\n}\r\n\r\ntd.header {\r\n	margin: 2px;\r\n	padding: 2px;\r\n}\r\n\r\n.lowercase {\r\n	text-transform: lowercase;\r\n}\r\n\r\n.uppercase {\r\n	text-transform: uppercase;\r\n}\r\n\r\n.capitalize {\r\n	text-transform: capitalize;\r\n}\r\n\r\n</style>\r\n'),
('Page', 'Number of white space characters before footer. The third party TCPDF library, which creates PDF pages for Allmice CMS, has a problem that footer text can not be centered correctly. Adding space characters before footer text helps to resolve this problem.', 'spaceBeforeFooter', 'viewPdfEvent', '8');

--
-- Dumping data for table `core_language`
--

INSERT INTO `core_language` (`language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
('en', 21, 'Page', 'addPageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Page', 'addPageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Page', 'addPageEvent', 'guide/bodyArea', 'Main content of the page.'),
('en', 21, 'Page', 'addPageEvent', 'guide/botTag', 'Html meta tag for robots.'),
('en', 21, 'Page', 'addPageEvent', 'guide/caching', 'Choose, for which roles this page will be cached. Hold down Ctrl key to check multiple roles.'),
('en', 21, 'Page', 'addPageEvent', 'guide/descriptionArea', 'Description of the page for html description meta tag. Helps Search Engine Optimizing. If field is empty, then default site wide, default Page module or default view method description will be used.'),
('en', 21, 'Page', 'addPageEvent', 'guide/label', 'Human readable label for menu item (if this field is empty, then no menu item will be used for this page).'),
('en', 21, 'Page', 'addPageEvent', 'guide/menuId', 'Choose menu, where this item belongs to (if no menu is chosen, then no menu item will be used for this page).'),
('en', 21, 'Page', 'addPageEvent', 'guide/parentId', 'Choose parent item in the menu for the current menu item.'),
('en', 21, 'Page', 'addPageEvent', 'guide/roleAccess', 'Choose, which roles can view this page. Hold down Ctrl key to check multiple roles.'),
('en', 21, 'Page', 'addPageEvent', 'guide/status', 'Choose, whether this page is published or not. Good to use this option if page is not ready yet or in other occasions.'),
('en', 21, 'Page', 'addPageEvent', 'guide/title', 'Title of the page (usually used for html title tag and in h1 tag). This field should not be empty.'),
('en', 21, 'Page', 'addPageEvent', 'guide/weight', 'Weight is an integer number, which determines order of menu items.'),
('en', 21, 'Page', 'addPageEvent', 'label/alias', 'URL alias'),
('en', 21, 'Page', 'addPageEvent', 'label/bodyArea', 'Body'),
('en', 21, 'Page', 'addPageEvent', 'label/botTag', 'Robot meta tag'),
('en', 21, 'Page', 'addPageEvent', 'label/caching', 'Caching for roles'),
('en', 21, 'Page', 'addPageEvent', 'label/descriptionArea', 'Description meta tag'),
('en', 21, 'Page', 'addPageEvent', 'label/label', 'Menu item label'),
('en', 21, 'Page', 'addPageEvent', 'label/menuId', 'Menu'),
('en', 21, 'Page', 'addPageEvent', 'label/parentId', 'Menu item location'),
('en', 21, 'Page', 'addPageEvent', 'label/roleAccess', 'Access right for roles'),
('en', 21, 'Page', 'addPageEvent', 'label/status', 'Page status'),
('en', 21, 'Page', 'addPageEvent', 'label/title', 'Title'),
('en', 21, 'Page', 'addPageEvent', 'label/weight', 'Weight'),
('en', 21, 'Page', 'addPageEvent', 'value/submit1', 'Save'),
('en', 22, 'Page', 'addPageEvent', 'botTagOption1', 'No tag (default - index, follow)'),
('en', 22, 'Page', 'addPageEvent', 'link1', 'Show list of pages!'),
('en', 22, 'Page', 'addPageEvent', 'subTitle1', 'Main area'),
('en', 22, 'Page', 'addPageEvent', 'subTitle2', 'Menu area'),
('en', 22, 'Page', 'addPageEvent', 'subTitle3', 'Other options'),
('en', 22, 'Page', 'addPageEvent', 'menuOption0', 'No menu is chosen'),
('en', 22, 'Page', 'addPageEvent', 'statusOption1', 'Published'),
('en', 22, 'Page', 'addPageEvent', 'statusOption2', 'Not published'),
('en', 22, 'Page', 'addPageEvent', 'submitMessage', 'Page was added.'),
('en', 22, 'Page', 'addPageEvent', 'aliasProblem', 'Alias is not correct and page was not saved. Most common causes for this problem: This alias may already exist for another page or starts with path of an installed module or does not have a leading slash (/) or has many leading slashes.'),
('en', 22, 'Page', 'addPageEvent', 'title', 'Add a New Page'),
('en', 21, 'Page', 'addSnippetEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Page', 'addSnippetEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Page', 'addSnippetEvent', 'guide/snippetCode', 'An unique code to identify this snippet from all the other snippets of the current page.'),
('en', 21, 'Page', 'addSnippetEvent', 'guide/snippetContent', 'Content of the snippet.'),
('en', 21, 'Page', 'addSnippetEvent', 'guide/snippetType', 'If type is plain text, then the content form field should include text, which will be displayed in snippet. If type is PHP code, then it should include location to the PHP code class and then refer to method, which will return the snippet content in this class, separated by ";". For example, something like: custom/modules/[ModuleName]/Model/[ClassFileName.php];[methodName].'),
('en', 21, 'Page', 'addSnippetEvent', 'label/snippetCode', 'Unique snippet code:'),
('en', 21, 'Page', 'addSnippetEvent', 'label/snippetContent', 'Snippet content:'),
('en', 21, 'Page', 'addSnippetEvent', 'label/snippetType', 'Snippet type:'),
('en', 21, 'Page', 'addSnippetEvent', 'value/save', 'Save'),
('en', 22, 'Page', 'addSnippetEvent', 'label1', 'Page title:'),
('en', 22, 'Page', 'addSnippetEvent', 'label2', 'Url alias:'),
('en', 22, 'Page', 'addSnippetEvent', 'label3', 'Start of page body:'),
('en', 22, 'Page', 'addSnippetEvent', 'link1', 'Show list of snippets!'),
('en', 22, 'Page', 'addSnippetEvent', 'message1', 'Page id is not correct.'),
('en', 22, 'Page', 'addSnippetEvent', 'message2', 'A page with such id does not exist or you can not add snippets to this page.'),
('en', 22, 'Page', 'addSnippetEvent', 'title', 'Add a New Snippet'),
('en', 22, 'Page', 'addSnippetEvent', 'typeOption1', 'Plain text'),
('en', 22, 'Page', 'addSnippetEvent', 'typeOption2', 'PHP code'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'afterField1', 'title'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'afterMessage', 'The page with following details was deleted:'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'beforeField1', 'title is'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'beforeMessage', 'Are you sure, that you wish to delete the page with following details?'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'beforeMessage2', 'Page details are:'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'link1', 'Show list of pages!'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'message1', 'Page id is not correct!'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'submitYes', 'Delete this page!'),
('en', 22, 'Page', 'deleteAnyPageEvent', 'title', 'Delete Page'),
('en', 22, 'Page', 'deletePostEvent', 'afterField1', 'Creator:'),
('en', 22, 'Page', 'deletePostEvent', 'afterField2', 'Posting time:'),
('en', 22, 'Page', 'deletePostEvent', 'afterField3', 'Start of content:'),
('en', 22, 'Page', 'deletePostEvent', 'afterMessage', 'Post with following details was deleted:'),
('en', 22, 'Page', 'deletePostEvent', 'beforeField1', 'Creator is:'),
('en', 22, 'Page', 'deletePostEvent', 'beforeField2', 'Posting time is:'),
('en', 22, 'Page', 'deletePostEvent', 'beforeField3', 'Start of content is:'),
('en', 22, 'Page', 'deletePostEvent', 'beforeMessage', 'Are you sure, that you wish to delete the post with following details?'),
('en', 22, 'Page', 'deletePostEvent', 'beforeMessage2', 'Post details are:'),
('en', 22, 'Page', 'deletePostEvent', 'intro', 'This post is related to page...'),
('en', 22, 'Page', 'deletePostEvent', 'label1', 'Page title:'),
('en', 22, 'Page', 'deletePostEvent', 'label2', 'Page alias:'),
('en', 22, 'Page', 'deletePostEvent', 'link1', 'List all pages!'),
('en', 22, 'Page', 'deletePostEvent', 'message1', 'Post id is not correct.'),
('en', 22, 'Page', 'deletePostEvent', 'submitYes', 'Delete this post!'),
('en', 22, 'Page', 'deletePostEvent', 'title', 'Delete an Existing Post'),
('en', 22, 'Page', 'deleteSnippetEvent', 'afterField1', 'Snippet code:'),
('en', 22, 'Page', 'deleteSnippetEvent', 'afterMessage', 'Snippet with following details was deleted:'),
('en', 22, 'Page', 'deleteSnippetEvent', 'beforeField1', 'Snippet code:'),
('en', 22, 'Page', 'deleteSnippetEvent', 'beforeMessage', 'Are you sure, that you wish to delete the snippet with following details?'),
('en', 22, 'Page', 'deleteSnippetEvent', 'beforeMessage2', 'Snippet details are:'),
('en', 22, 'Page', 'deleteSnippetEvent', 'label1', 'Page title:'),
('en', 22, 'Page', 'deleteSnippetEvent', 'label2', 'Url alias:'),
('en', 22, 'Page', 'deleteSnippetEvent', 'label3', 'Start of page body:'),
('en', 22, 'Page', 'deleteSnippetEvent', 'link1', 'Show list of snippets!'),
('en', 22, 'Page', 'deleteSnippetEvent', 'message1', 'Snippet id is not correct.'),
('en', 22, 'Page', 'deleteSnippetEvent', 'submitYes', 'Delete this snippet!'),
('en', 22, 'Page', 'deleteSnippetEvent', 'title', 'Delete an Existing Snippet'),
('en', 21, 'Page', 'editAnyPageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Page', 'editAnyPageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/bodyArea', 'Main content of the page.'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/botTag', 'Html meta tag for robots.'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/caching', 'Choose, for which roles this page will be cached. Hold down Ctrl key to check multiple roles.'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/descriptionArea', 'Description of the page for html description meta tag. Helps Search Engine Optimizing. If field is empty, then default site wide, default Page module or default view method description will be used.'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/label', 'Human readable label for menu item (if this field is empty, then no menu item will be used for this page).'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/menuId', 'Choose menu, where this item belongs to (if no menu is chosen, then no menu item will be used for this page).'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/parentId', 'Choose parent item in the menu for the current menu item.'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/roleAccess', 'Choose, which roles can view this page. Hold down Ctrl key to check multiple roles.'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/status', 'Choose, whether this page is published or not. Good to use this option if page is not ready yet or in other occasions.'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/title', 'Title of the page (usually used for html title tag and in h1 tag). This field should not be empty.'),
('en', 21, 'Page', 'editAnyPageEvent', 'guide/weight', 'Weight is an integer number, which determines order of menu items.'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/alias', 'URL alias'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/bodyArea', 'Body'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/botTag', 'Robot meta tag'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/caching', 'Caching for roles'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/descriptionArea', 'Description meta tag'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/label', 'Menu item label'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/menuId', 'Menu'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/parentId', 'Menu item location'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/roleAccess', 'Access right for roles'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/status', 'Page status'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/title', 'Title'),
('en', 21, 'Page', 'editAnyPageEvent', 'label/weight', 'Weight'),
('en', 21, 'Page', 'editAnyPageEvent', 'value/submit1', 'Save'),
('en', 22, 'Page', 'editAnyPageEvent', 'botTagOption1', 'No tag (default - index, follow)'),
('en', 22, 'Page', 'editAnyPageEvent', 'link1', 'Show list of pages!'),
('en', 22, 'Page', 'editAnyPageEvent', 'link1b', 'View'),
('en', 22, 'Page', 'editAnyPageEvent', 'subTitle1', 'Main area'),
('en', 22, 'Page', 'editAnyPageEvent', 'subTitle2', 'Menu area'),
('en', 22, 'Page', 'editAnyPageEvent', 'subTitle3', 'Other options'),
('en', 22, 'Page', 'editAnyPageEvent', 'link4', 'List snippets!'),
('en', 22, 'Page', 'editAnyPageEvent', 'link5', 'Add a snippet!'),
('en', 22, 'Page', 'editAnyPageEvent', 'menuOption0', 'No menu is chosen'),
('en', 22, 'Page', 'editAnyPageEvent', 'message1', 'Page id is not correct!'),
('en', 22, 'Page', 'editAnyPageEvent', 'statusOption1', 'Published'),
('en', 22, 'Page', 'editAnyPageEvent', 'statusOption2', 'Not published'),
('en', 22, 'Page', 'editAnyPageEvent', 'submitMessage', 'Page was saved at'),
('en', 22, 'Page', 'editAnyPageEvent', 'title', 'Edit an Existing Page'),
('en', 21, 'Page', 'editPostEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Page', 'editPostEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Page', 'editPostEvent', 'guide/postContent', 'Content of the post.'),
('en', 21, 'Page', 'editPostEvent', 'guide/postStatus', 'Choose, whether this post is published or not.'),
('en', 21, 'Page', 'editPostEvent', 'label/postContent', 'Post content:'),
('en', 21, 'Page', 'editPostEvent', 'label/postStatus', 'Post status:'),
('en', 21, 'Page', 'editPostEvent', 'value/save', 'Save'),
('en', 22, 'Page', 'editPostEvent', 'message1', 'Post id is not correct.'),
('en', 22, 'Page', 'editPostEvent', 'message2', 'A post with such id does not exist or you have no access right to edit it.'),
('en', 22, 'Page', 'editPostEvent', 'message3', 'Page id is not correct.'),
('en', 22, 'Page', 'editPostEvent', 'submitMessage', 'Post was updated.'),
('en', 22, 'Page', 'editPostEvent', 'title', 'Edit an Existing Post'),
('en', 21, 'Page', 'editSnippetEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Page', 'editSnippetEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Page', 'editSnippetEvent', 'guide/snippetCode', 'An unique code to identify this snippet from all the other snippets of the current page.'),
('en', 21, 'Page', 'editSnippetEvent', 'guide/snippetContent', 'Content of the snippet.'),
('en', 21, 'Page', 'editSnippetEvent', 'guide/snippetType', 'If type is plain text, then the content form field should include text, which will be displayed in snippet. If type is PHP code, then it should include location to the PHP code class and then refer to method, which will return the snippet content in this class, separated by ";". For example, something like: custom/modules/[ModuleName]/Model/[ClassFileName.php];[methodName].'),
('en', 21, 'Page', 'editSnippetEvent', 'label/snippetCode', 'Unique snippet code:'),
('en', 21, 'Page', 'editSnippetEvent', 'label/snippetContent', 'Snippet content:'),
('en', 21, 'Page', 'editSnippetEvent', 'label/snippetType', 'Snippet type:'),
('en', 21, 'Page', 'editSnippetEvent', 'value/save', 'Save'),
('en', 22, 'Page', 'editSnippetEvent', 'field1', 'Snippet code:'),
('en', 22, 'Page', 'editSnippetEvent', 'label1', 'Page title:'),
('en', 22, 'Page', 'editSnippetEvent', 'label2', 'Url alias:'),
('en', 22, 'Page', 'editSnippetEvent', 'label3', 'Start of page body:'),
('en', 22, 'Page', 'editSnippetEvent', 'link1', 'Show list of snippets!'),
('en', 22, 'Page', 'editSnippetEvent', 'message1', 'Snippet id is not correct.'),
('en', 22, 'Page', 'editSnippetEvent', 'message2', 'A snippet with such id does not exist or you can not edit it.'),
('en', 22, 'Page', 'editSnippetEvent', 'title', 'Edit an Existing Snippet'),
('en', 22, 'Page', 'editSnippetEvent', 'typeOption1', 'Plain text'),
('en', 22, 'Page', 'editSnippetEvent', 'typeOption2', 'PHP code'),
('en', 22, 'Page', 'indexEvent', 'link1a', 'Add a new page'),
('en', 22, 'Page', 'indexEvent', 'link1b', 'List own pages'),
('en', 22, 'Page', 'indexEvent', 'link1c', 'List all pages'),
('en', 22, 'Page', 'indexEvent', 'link2', 'Edit'),
('en', 22, 'Page', 'indexEvent', 'link3', 'Delete'),
('en', 22, 'Page', 'indexEvent', 'link4', 'View source'),
('en', 22, 'Page', 'indexEvent', 'link5', 'View alias'),
('en', 22, 'Page', 'indexEvent', 'message1', 'There are no pages.'),
('en', 22, 'Page', 'indexEvent', 'statusOption1', 'Published'),
('en', 22, 'Page', 'indexEvent', 'statusOption2', 'Not published'),
('en', 22, 'Page', 'indexEvent', 'tb1BodyStart', 'Start of body'),
('en', 22, 'Page', 'indexEvent', 'tb1Created', 'Created'),
('en', 22, 'Page', 'indexEvent', 'tb1Creator', 'Creator'),
('en', 22, 'Page', 'indexEvent', 'tb1Modified', 'Modified'),
('en', 22, 'Page', 'indexEvent', 'tb1PageTitle', 'Title'),
('en', 22, 'Page', 'indexEvent', 'tb1Status', 'Status'),
('en', 22, 'Page', 'indexEvent', 'tb1Title', 'List of pages'),
('en', 22, 'Page', 'indexEvent', 'title', 'List of All Pages'),
('en', 22, 'Page', 'listAllPagesEvent', 'link1', 'Add a new page'),
('en', 22, 'Page', 'listAllPagesEvent', 'link2', 'Edit'),
('en', 22, 'Page', 'listAllPagesEvent', 'link3', 'Delete'),
('en', 22, 'Page', 'listAllPagesEvent', 'link4', 'View source'),
('en', 22, 'Page', 'listAllPagesEvent', 'link5', 'View alias'),
('en', 22, 'Page', 'listAllPagesEvent', 'message1', 'There are no pages.'),
('en', 22, 'Page', 'listAllPagesEvent', 'statusOption1', 'Published'),
('en', 22, 'Page', 'listAllPagesEvent', 'statusOption2', 'Not published'),
('en', 22, 'Page', 'listAllPagesEvent', 'tb1BodyStart', 'Start of body'),
('en', 22, 'Page', 'listAllPagesEvent', 'tb1Created', 'Created'),
('en', 22, 'Page', 'listAllPagesEvent', 'tb1Creator', 'Creator'),
('en', 22, 'Page', 'listAllPagesEvent', 'tb1Modified', 'Modified'),
('en', 22, 'Page', 'listAllPagesEvent', 'tb1PageTitle', 'Title'),
('en', 22, 'Page', 'listAllPagesEvent', 'tb1Status', 'Status'),
('en', 22, 'Page', 'listAllPagesEvent', 'tb1Title', 'List of pages'),
('en', 22, 'Page', 'listAllPagesEvent', 'title', 'List of All Pages'),
('en', 22, 'Page', 'listSnippetsEvent', 'label1', 'Page title:'),
('en', 22, 'Page', 'listSnippetsEvent', 'label2', 'Url alias:'),
('en', 22, 'Page', 'listSnippetsEvent', 'label3', 'Start of page body:'),
('en', 22, 'Page', 'listSnippetsEvent', 'link1', 'Add snippet'),
('en', 22, 'Page', 'listSnippetsEvent', 'link2', 'Edit'),
('en', 22, 'Page', 'listSnippetsEvent', 'link3', 'Delete'),
('en', 22, 'Page', 'listSnippetsEvent', 'message1', 'Page id is not correct.'),
('en', 22, 'Page', 'listSnippetsEvent', 'message2', 'There are no snippets for this page.'),
('en', 22, 'Page', 'listSnippetsEvent', 'tb1SnCode', 'Snippet code'),
('en', 22, 'Page', 'listSnippetsEvent', 'tb1SnContent', 'Snippet content'),
('en', 22, 'Page', 'listSnippetsEvent', 'title', 'List of Snippets'),
('en', 21, 'Page', 'managePostingAccessEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Page', 'managePostingAccessEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Page', 'managePostingAccessEvent', 'guide/postingAccess', 'Tick this box to allow posting by other visitors on the corresponding page or untick it, if you wish not to allow such posting!'),
('en', 21, 'Page', 'managePostingAccessEvent', 'guide/postingIntro', 'Write some introduction to let people know, that they can post comments to this page.'),
('en', 21, 'Page', 'managePostingAccessEvent', 'guide/postStatus', 'Choose, whether a post is after writing it by default published or not.'),
('en', 21, 'Page', 'managePostingAccessEvent', 'label/postingIntro', 'Posting introduction:'),
('en', 21, 'Page', 'managePostingAccessEvent', 'label/postStatus', 'Post default status:'),
('en', 21, 'Page', 'managePostingAccessEvent', 'value/save', 'Save'),
('en', 22, 'Page', 'managePostingAccessEvent', 'intro', 'This post is related to page...'),
('en', 22, 'Page', 'managePostingAccessEvent', 'label-postingAccess', 'Posting enabled'),
('en', 22, 'Page', 'managePostingAccessEvent', 'label1', 'Page title:'),
('en', 22, 'Page', 'managePostingAccessEvent', 'label2', 'Page alias:'),
('en', 22, 'Page', 'managePostingAccessEvent', 'message1', 'Page id is not correct.'),
('en', 22, 'Page', 'managePostingAccessEvent', 'title', 'Manage Posting Access'),
('en', 22, 'Page', 'viewEvent', 'link1', 'Edit'),
('en', 22, 'Page', 'viewEvent', 'postCreatorLabel', 'Created by:'),
('en', 22, 'Page', 'viewEvent', 'postEditorLabel', 'Edited by:'),
('en', 22, 'Page', 'viewEvent', 'postError1', 'Field “[elLabel]” is invalid!'),
('en', 22, 'Page', 'viewEvent', 'postError2', 'Captcha code is not correct.'),
('en', 22, 'Page', 'viewEvent', 'postLabel1', 'Your name *'),
('en', 22, 'Page', 'viewEvent', 'postLabel2', 'Your email *'),
('en', 22, 'Page', 'viewEvent', 'postLabel3', 'Your comment *'),
('en', 22, 'Page', 'viewEvent', 'postLink1', 'Edit post'),
('en', 22, 'Page', 'viewEvent', 'postLink2', 'Delete post'),
('en', 22, 'Page', 'viewEvent', 'postLink3', 'Manage posting access'),
('en', 22, 'Page', 'viewEvent', 'postNote1', 'Not published'),
('en', 22, 'Page', 'viewEvent', 'postSubmit', 'Submit comment'),
('en', 22, 'Page', 'viewEvent', 'captchaNewCode', 'Get another code'),
('en', 22, 'Page', 'viewEvent', 'captchaBoxLabel', 'Type the characters in the image'),
('en', 22, 'Page', 'editAnyPageEvent', 'submitMessageEnd', '.'),
('en', 22, 'Page', 'editAnyPageEvent', 'aliasProblem', 'Alias is not correct and page was not saved. Most common causes for this problem: This alias may already exist for another page or starts with path of an installed module or does not have a leading slash (/) or has many leading slashes.'),
('en', 22, 'Page', 'indexEvent', 'buttonShowCols', 'Show more columns'),
('en', 22, 'Page', 'indexEvent', 'buttonHideCols', 'Hide some columns'),
('en', 22, 'Page', 'listAllPagesEvent', 'buttonShowCols', 'Show more columns'),
('en', 22, 'Page', 'listAllPagesEvent', 'buttonHideCols', 'Hide some columns'),
('en', 22, 'Page', 'viewEvent', 'link2', 'PDF'),
('en', 22, 'Page', 'viewPdfEvent', 'footerText', 'Page');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mod_page`
--
ALTER TABLE `mod_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_page_post`
--
ALTER TABLE `mod_page_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_page_snippet`
--
ALTER TABLE `mod_page_snippet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mod_page`
--
ALTER TABLE `mod_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mod_page_post`
--
ALTER TABLE `mod_page_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `mod_page_snippet`
--
ALTER TABLE `mod_page_snippet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
