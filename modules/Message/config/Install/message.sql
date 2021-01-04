-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 10, 2017 at 02:12 AM
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
-- Table structure for table `mod_message`
--

CREATE TABLE `mod_message` (
  `id` int(11) NOT NULL,
  `sender_user_id` int(11) NOT NULL DEFAULT '0',
  `sender_name` varchar(60) NOT NULL DEFAULT '',
  `sender_email_address` varchar(120) NOT NULL DEFAULT '',
  `receiver_user_id` int(11) NOT NULL DEFAULT '0',
  `receiver_name` varchar(60) NOT NULL DEFAULT '',
  `receiver_contact_form_id` int(11) NOT NULL DEFAULT '0',
  `receiver_email_address` varchar(120) NOT NULL DEFAULT '',
  `subject` varchar(120) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0',
  `content` varchar(2000) NOT NULL DEFAULT '',
  `status_for_sender` varchar(15) NOT NULL DEFAULT 'sent',
  `status_for_receiver` varchar(15) NOT NULL DEFAULT 'sent',
  `ip_v4` varchar(15) NOT NULL DEFAULT '192.168.0.0',
  `type` varchar(30) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(250) NOT NULL DEFAULT '',
  `language_code` varchar(15) NOT NULL DEFAULT 'en' COMMENT 'Two character code (ISO 639-1) or some other code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mod_message_template`
--

CREATE TABLE `mod_message_template` (
  `id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL DEFAULT '',
  `subject` varchar(120) NOT NULL DEFAULT '',
  `module` varchar(30) NOT NULL DEFAULT '',
  `type` varchar(30) NOT NULL DEFAULT '',
  `content_html` varchar(2000) NOT NULL DEFAULT '',
  `content_plain` varchar(2000) NOT NULL DEFAULT '',
  `language_code` varchar(15) NOT NULL DEFAULT 'en' COMMENT 'Two character code (ISO 639-1) or some other code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`module_name`, `description`, `uri`, `type`, `value`) VALUES
('Message', 'Mail server host name, which will be used to authenticate the outgoing by system generated e-mail.', 'host', 'emailAuthentication', 'smtp.gmail.com'),
('Message', 'Mail server port number, which will be used to authenticate the outgoing by system generated e-mail.', 'port', 'emailAuthentication', '587'),
('Message', 'Mail account username, which will be used to authenticate the outgoing by system generated e-mail.', 'username', 'emailAuthentication', ''),
('Message', 'Mail account password, which will be used to authenticate the outgoing by system generated e-mail.', 'password', 'emailAuthentication', ''),
('Message', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
('Message', 'Form validation regular expression pattern for username fields.', 'username', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,60}$/'),
('Message', 'Form validation regular expression pattern for person name fields.', 'personName', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,120}$/'),
('Message', 'Form validation regular expression pattern for e-mail fields.', 'eMail', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
('Message', 'Form validation regular expression pattern for human readable medium text fields.', 'text255', 'formValidationRegEx', '/^(.){0,255}$/'),
('Message', 'Form validation regular expression pattern for medium textarea fields (e.g. description).', 'mediumTextarea', 'formValidationRegEx', '/^(.){0,2000}$/s'),
('Message', 'Timezone value for sending emails. See http://php.net/manual/en/timezones.php for correct values.', 'timezone', 'email', 'Europe/London');

--
-- Dumping data for table `core_language`
--

INSERT INTO `core_language` (`language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
('en', 21, 'Message', 'addTemplateEvent', 'guide/code', 'A unique code (identifier) for computer as array key to use this template in modules. Suggested as camelCase string without spaces. E.g. \"sendAccValCode\".'),
('en', 21, 'Message', 'addTemplateEvent', 'guide/contentHtml', 'Template for the HTML text content part of a message.'),
('en', 21, 'Message', 'addTemplateEvent', 'guide/contentPlain', 'Template for the plain text content part of a message.'),
('en', 21, 'Message', 'addTemplateEvent', 'guide/language', 'Two character code (ISO 639-1) or some other language code.'),
('en', 21, 'Message', 'addTemplateEvent', 'guide/module', 'Name of the module, which is using this template to compose messages.'),
('en', 21, 'Message', 'addTemplateEvent', 'guide/subject', 'Template for the subject part of a message.'),
('en', 21, 'Message', 'addTemplateEvent', 'guide/type', 'Some type string, which helps to filter out specific templates. This type can be used to list specific templates.'),
('en', 21, 'Message', 'addTemplateEvent', 'label/code', 'Code'),
('en', 21, 'Message', 'addTemplateEvent', 'label/contentHtml', 'HTML content template'),
('en', 21, 'Message', 'addTemplateEvent', 'label/contentPlain', 'Plain content template'),
('en', 21, 'Message', 'addTemplateEvent', 'label/language', 'Language'),
('en', 21, 'Message', 'addTemplateEvent', 'label/module', 'Module'),
('en', 21, 'Message', 'addTemplateEvent', 'label/subject', 'Message subject template'),
('en', 21, 'Message', 'addTemplateEvent', 'label/type', 'Type'),
('en', 21, 'Message', 'addTemplateEvent', 'value/save', 'Save'),
('en', 22, 'Message', 'addTemplateEvent', 'title', 'Add a New Message Template'),
('en', 22, 'Message', 'deleteTemplateEvent', 'afterField1', 'code'),
('en', 22, 'Message', 'deleteTemplateEvent', 'afterField2', 'module name'),
('en', 22, 'Message', 'deleteTemplateEvent', 'afterField3', 'type'),
('en', 22, 'Message', 'deleteTemplateEvent', 'afterField4', 'subject'),
('en', 22, 'Message', 'deleteTemplateEvent', 'afterMessage', 'The message template with following details was deleted:'),
('en', 22, 'Message', 'deleteTemplateEvent', 'beforeField1', 'code is'),
('en', 22, 'Message', 'deleteTemplateEvent', 'beforeField2', 'module name is'),
('en', 22, 'Message', 'deleteTemplateEvent', 'beforeField3', 'type is'),
('en', 22, 'Message', 'deleteTemplateEvent', 'beforeField4', 'subject is'),
('en', 22, 'Message', 'deleteTemplateEvent', 'beforeMessage', 'Are you sure, that you wish to delete the template with following details?'),
('en', 22, 'Message', 'deleteTemplateEvent', 'beforeMessage2', 'Message template details are:'),
('en', 22, 'Message', 'deleteTemplateEvent', 'link1', 'Show list of message templates!'),
('en', 22, 'Message', 'deleteTemplateEvent', 'submitYes', 'Delete this template!'),
('en', 22, 'Message', 'deleteTemplateEvent', 'title', 'Delete a Message Template'),
('en', 21, 'Message', 'editTemplateEvent', 'guide/code', 'A unique code (identifier) for computer as array key to use this template in modules. Suggested as camelCase string without spaces. E.g. \"sendAccValCode\".'),
('en', 21, 'Message', 'editTemplateEvent', 'guide/contentHtml', 'Template for the HTML text content part of a message.'),
('en', 21, 'Message', 'editTemplateEvent', 'guide/contentPlain', 'Template for the plain text content part of a message.'),
('en', 21, 'Message', 'editTemplateEvent', 'guide/language', 'Two character code (ISO 639-1) or some other language code.'),
('en', 21, 'Message', 'editTemplateEvent', 'guide/module', 'Name of the module, which is using this template to compose messages.'),
('en', 21, 'Message', 'editTemplateEvent', 'guide/subject', 'Template for the subject part of a message.'),
('en', 21, 'Message', 'editTemplateEvent', 'guide/type', 'Some type string, which helps to filter out specific templates. This type can be used to list specific templates.'),
('en', 21, 'Message', 'editTemplateEvent', 'label/code', 'Code'),
('en', 21, 'Message', 'editTemplateEvent', 'label/contentHtml', 'HTML content template'),
('en', 21, 'Message', 'editTemplateEvent', 'label/contentPlain', 'Plain content template'),
('en', 21, 'Message', 'editTemplateEvent', 'label/language', 'Language'),
('en', 21, 'Message', 'editTemplateEvent', 'label/module', 'Module'),
('en', 21, 'Message', 'editTemplateEvent', 'label/subject', 'Message subject template'),
('en', 21, 'Message', 'editTemplateEvent', 'label/type', 'Type'),
('en', 21, 'Message', 'editTemplateEvent', 'value/save', 'Save'),
('en', 22, 'Message', 'editTemplateEvent', 'title', 'Edit an Existing Message Template'),
('en', 22, 'Message', 'listTemplatesEvent', 'link1', 'Add'),
('en', 22, 'Message', 'listTemplatesEvent', 'link2', 'Edit'),
('en', 22, 'Message', 'listTemplatesEvent', 'link3', 'Delete'),
('en', 22, 'Message', 'listTemplatesEvent', 'message1', 'There are no templates.'),
('en', 22, 'Message', 'listTemplatesEvent', 'tb1Code', 'Code'),
('en', 22, 'Message', 'listTemplatesEvent', 'tb1Module', 'Module'),
('en', 22, 'Message', 'listTemplatesEvent', 'tb1Subject', 'Subject'),
('en', 22, 'Message', 'listTemplatesEvent', 'tb1Type', 'Type'),
('en', 22, 'Message', 'listTemplatesEvent', 'title', 'List of Message Templates'),
('en', 22, 'Message', 'listMessagesEvent', 'link1', 'Write a new message'),
('en', 22, 'Message', 'listMessagesEvent', 'link2', 'List user blockings'),
('en', 22, 'Message', 'listMessagesEvent', 'message1', 'There are no received messages.'),
('en', 22, 'Message', 'listMessagesEvent', 'message2', 'There are no sent or unsent saved messages.'),
('en', 22, 'Message', 'listMessagesEvent', 'tb1Title', 'Received messages:'),
('en', 22, 'Message', 'listMessagesEvent', 'tb1ColSubject', 'Subject'),
('en', 22, 'Message', 'listMessagesEvent', 'tb1ColSender', 'Sender'),
('en', 22, 'Message', 'listMessagesEvent', 'tb1ColTime', 'Time'),
('en', 22, 'Message', 'listMessagesEvent', 'tb1ColStatus', 'Status'),
('en', 22, 'Message', 'listMessagesEvent', 'tb1LinkRead', 'Read'),
('en', 22, 'Message', 'listMessagesEvent', 'tb1LinkReply', 'Reply'),
('en', 22, 'Message', 'listMessagesEvent', 'tb1LinkDelete', 'Delete'),
('en', 22, 'Message', 'listMessagesEvent', 'tb2Title', 'Sent or unsent saved messages:'),
('en', 22, 'Message', 'listMessagesEvent', 'tb2ColSubject', 'Subject'),
('en', 22, 'Message', 'listMessagesEvent', 'tb2ColRecipient', 'Sender'),
('en', 22, 'Message', 'listMessagesEvent', 'tb2ColTime', 'Time'),
('en', 22, 'Message', 'listMessagesEvent', 'tb2ColStatus', 'Status'),
('en', 22, 'Message', 'listMessagesEvent', 'tb2LinkRead', 'Read'),
('en', 22, 'Message', 'listMessagesEvent', 'tb2LinkEdit', 'Edit'),
('en', 22, 'Message', 'listMessagesEvent', 'tb2LinkDelete', 'Delete'),
('en', 22, 'Message', 'listMessagesEvent', 'title', 'List of My Messages'),
('en', 22, 'Message', 'listMessagesEvent', 'statusOption1', 'Unsent'),
('en', 22, 'Message', 'listMessagesEvent', 'statusOption2', 'Sent'),
('en', 22, 'Message', 'listMessagesEvent', 'statusOption3', 'Unread'),
('en', 22, 'Message', 'listMessagesEvent', 'senderSystem', 'Automated system message'),
('en', 21, 'Message', 'writeMessageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Message', 'writeMessageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Message', 'writeMessageEvent', 'guide/receiverName', ''),
('en', 21, 'Message', 'writeMessageEvent', 'guide/subject', ''),
('en', 21, 'Message', 'writeMessageEvent', 'guide/content', ''),
('en', 21, 'Message', 'writeMessageEvent', 'label/receiverName', 'Receiver Name:'),
('en', 21, 'Message', 'writeMessageEvent', 'label/subject', 'Subject:'),
('en', 21, 'Message', 'writeMessageEvent', 'label/content', 'Content:'),
('en', 21, 'Message', 'writeMessageEvent', 'value/save', 'Save'),
('en', 21, 'Message', 'writeMessageEvent', 'value/send', 'Send'),
('en', 22, 'Message', 'writeMessageEvent', 'message1', 'Message was saved.'),
('en', 22, 'Message', 'writeMessageEvent', 'message2', 'Authentication email address (username) and/or password are not configured.'),
('en', 22, 'Message', 'writeMessageEvent', 'message3', 'Message was sent.'),
('en', 22, 'Message', 'writeMessageEvent', 'message4', 'You can not send message to such user - such user does not exist or has blocking for receiving messages.'),
('en', 22, 'Message', 'writeMessageEvent', 'replyStart', '--------------------\nAt [messageTime], [senderName] wrote:\n'),
('en', 22, 'Message', 'writeMessageEvent', 'link1', 'Show list of messages!'),
('en', 22, 'Message', 'writeMessageEvent', 'title', 'Write a Message'),
('en', 21, 'Message', 'editMessageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Message', 'editMessageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Message', 'editMessageEvent', 'guide/receiverName', ''),
('en', 21, 'Message', 'editMessageEvent', 'guide/subject', ''),
('en', 21, 'Message', 'editMessageEvent', 'guide/content', ''),
('en', 21, 'Message', 'editMessageEvent', 'label/receiverName', 'Receiver Name:'),
('en', 21, 'Message', 'editMessageEvent', 'label/subject', 'Subject:'),
('en', 21, 'Message', 'editMessageEvent', 'label/content', 'Content:'),
('en', 21, 'Message', 'editMessageEvent', 'value/save', 'Save'),
('en', 21, 'Message', 'editMessageEvent', 'value/send', 'Send'),
('en', 22, 'Message', 'editMessageEvent', 'message1', 'Message was saved.'),
('en', 22, 'Message', 'editMessageEvent', 'message2', 'Authentication email address (username) and/or password are not configured.'),
('en', 22, 'Message', 'editMessageEvent', 'message3', 'Message was sent.'),
('en', 22, 'Message', 'editMessageEvent', 'message4', 'You can not send message to such user - such user does not exist or has blocking for receiving messages.'),
('en', 22, 'Message', 'editMessageEvent', 'message5', 'Such message does not exist or you can not access it.'),
('en', 22, 'Message', 'editMessageEvent', 'link1', 'Show list of messages!'),
('en', 22, 'Message', 'editMessageEvent', 'title', 'Edit Own Message'),
('en', 22, 'Message', 'deleteMessageEvent', 'afterMessage', 'The message with following details was deleted:'),
('en', 22, 'Message', 'deleteMessageEvent', 'beforeField1', 'sender is:'),
('en', 22, 'Message', 'deleteMessageEvent', 'beforeField2', 'recipient is:'),
('en', 22, 'Message', 'deleteMessageEvent', 'beforeField3', 'time is:'),
('en', 22, 'Message', 'deleteMessageEvent', 'beforeField4', 'subject is:'),
('en', 22, 'Message', 'deleteMessageEvent', 'beforeMessage', 'Are you sure, that you wish to delete the message with following details?'),
('en', 22, 'Message', 'deleteMessageEvent', 'beforeMessage2', 'Message details are:'),
('en', 22, 'Message', 'deleteMessageEvent', 'message1', 'Such message does not exist or you can not access it.'),
('en', 22, 'Message', 'deleteMessageEvent', 'message2', 'Message id is not correct.'),
('en', 22, 'Message', 'deleteMessageEvent', 'submitYes', 'Delete this message!'),
('en', 22, 'Message', 'deleteMessageEvent', 'title', 'Delete Own Message'),
('en', 22, 'Message', 'deleteMessageEvent', 'afterField1', 'from:'),
('en', 22, 'Message', 'deleteMessageEvent', 'afterField2', 'to:'),
('en', 22, 'Message', 'deleteMessageEvent', 'afterField3', 'time:'),
('en', 22, 'Message', 'deleteMessageEvent', 'afterField4', 'subject:'),
('en', 22, 'Message', 'deleteMessageEvent', 'link1', 'Show list of messages!'),
('en', 22, 'Message', 'viewMessageEvent', 'link1', 'Show list of messages!'),
('en', 22, 'Message', 'viewMessageEvent', 'message1', 'Such message does not exist or you can not access it.'),
('en', 22, 'Message', 'viewMessageEvent', 'message2', 'Automated system message.'),
('en', 22, 'Message', 'viewMessageEvent', 'message3', 'Message id is not correct.'),
('en', 22, 'Message', 'viewMessageEvent', 'label1', 'From:'),
('en', 22, 'Message', 'viewMessageEvent', 'label2', 'To:'),
('en', 22, 'Message', 'viewMessageEvent', 'label3', 'Time:'),
('en', 22, 'Message', 'viewMessageEvent', 'label4', 'Subject:'),
('en', 22, 'Message', 'viewMessageEvent', 'label5', 'Content:'),
('en', 22, 'Message', 'viewMessageEvent', 'title', 'View Own Message'),
('en', 21, 'Message', 'addUserBlockingEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
('en', 21, 'Message', 'addUserBlockingEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
('en', 21, 'Message', 'addUserBlockingEvent', 'guide/username', ''),
('en', 21, 'Message', 'addUserBlockingEvent', 'label/username', 'Username:'),
('en', 21, 'Message', 'addUserBlockingEvent', 'value/save', 'Save'),
('en', 22, 'Message', 'addUserBlockingEvent', 'title', 'Add User Blocking'),
('en', 22, 'Message', 'addUserBlockingEvent', 'link1', 'Show list of blocked users!'),
('en', 22, 'Message', 'addUserBlockingEvent', 'message1', 'User [username] was added to the blocking list.'),
('en', 22, 'Message', 'addUserBlockingEvent', 'message2', 'Such user does not exist, is administrator or is already blocked.'),
('en', 22, 'Message', 'addUserBlockingEvent', 'message3', 'There are too many user blockings. To add new user blockings remove some old blockings. Be aware, that the limit amount of user blockings depends on the lengths of usernames.'),
('en', 22, 'Message', 'listUserBlockingsEvent', 'link1', 'Block a user'),
('en', 22, 'Message', 'listUserBlockingsEvent', 'link2', 'Show list of messages'),
('en', 22, 'Message', 'listUserBlockingsEvent', 'tb1Title', 'Blocked users are:'),
('en', 22, 'Message', 'listUserBlockingsEvent', 'tb1ColName', 'Username'),
('en', 22, 'Message', 'listUserBlockingsEvent', 'tb1LinkRemove', 'Remove blocking'),
('en', 22, 'Message', 'listUserBlockingsEvent', 'message1', 'There are no blocked users.'),
('en', 22, 'Message', 'listUserBlockingsEvent', 'title', 'List of Blocked Users'),
('en', 22, 'Message', 'removeUserBlockingEvent', 'title', 'Remove a Blocked User'),
('en', 22, 'Message', 'removeUserBlockingEvent', 'link1', 'Show list of blocked users!'),
('en', 22, 'Message', 'removeUserBlockingEvent', 'message1', 'User [username] was removed from the blocking list.'),
('en', 22, 'Message', 'removeUserBlockingEvent', 'message2', 'Such user does not exist, is administrator or is not in blocking list.');

--
-- Dumping data for table `mod_message_template`
--

INSERT INTO `mod_message_template` (`code`, `subject`, `module`, `type`, `content_html`, `content_plain`, `language_code`) VALUES
('wrapperUser', 'Member [memberName] of [websiteName]: [messageSubject]', 'Message', 'wrapper', 'Before reply, please read the note at the end of this email!\r\nThis is a message from the member [memberName] of [websiteName], who sent it to you through this website.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Log in to the website instead and use the reply link of this message in the list of your messages, which you can find on [listMessages].\r\nIf you wish to avoid such user messages in the future, then you can add message blockings to users on [addUserBlocking].', 'Before reply, please read the note at the end of this email!\r\nThis is a message from the member [memberName] of [websiteName], who sent it to you through this website.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Log in to the website instead and use the reply link of this message in the list of your messages, which you can find on [listMessages].\r\nIf you wish to avoid such user messages in the future, then you can add message blockings to users on [addUserBlocking].', 'en');


--
-- Indexes for dumped tables
--

--
-- Indexes for table `mod_message`
--
ALTER TABLE `mod_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_message_template`
--
ALTER TABLE `mod_message_template`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mod_message`
--
ALTER TABLE `mod_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `am1_mod_message_template`
--
ALTER TABLE `mod_message_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
