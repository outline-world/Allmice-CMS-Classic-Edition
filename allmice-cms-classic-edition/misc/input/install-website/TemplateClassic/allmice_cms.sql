-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 06, 2019 at 02:32 AM
-- Server version: 10.1.38-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.15-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `X`
--

-- --------------------------------------------------------

--
-- Table structure for table `core_access`
--

CREATE TABLE `core_access` (
  `id` int(11) NOT NULL,
  `role_id` smallint(5) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `access_level` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'No access: 0; Access granted: 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_access`
--

INSERT INTO `core_access` (`id`, `role_id`, `resource_id`, `access_level`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 0),
(3, 3, 1, 0),
(4, 1, 2, 1),
(5, 2, 2, 0),
(6, 3, 2, 0),
(7, 1, 3, 1),
(8, 2, 3, 0),
(9, 3, 3, 0),
(10, 1, 4, 1),
(11, 2, 4, 0),
(12, 3, 4, 0),
(13, 1, 5, 1),
(14, 2, 5, 0),
(15, 3, 5, 0),
(16, 1, 6, 1),
(17, 2, 6, 1),
(18, 3, 6, 1),
(19, 1, 7, 1),
(20, 2, 7, 1),
(21, 3, 7, 1),
(22, 1, 8, 1),
(23, 2, 8, 1),
(24, 3, 8, 1),
(25, 1, 9, 1),
(26, 2, 9, 1),
(27, 3, 9, 1),
(28, 1, 10, 1),
(29, 2, 10, 1),
(30, 3, 10, 1),
(31, 1, 11, 1),
(32, 2, 11, 1),
(33, 3, 11, 1),
(34, 1, 12, 1),
(35, 2, 12, 0),
(36, 3, 12, 0),
(37, 1, 13, 1),
(38, 2, 13, 0),
(39, 3, 13, 0),
(40, 1, 14, 1),
(41, 2, 14, 0),
(42, 3, 14, 0),
(43, 1, 15, 1),
(44, 2, 15, 0),
(45, 3, 15, 0),
(46, 1, 16, 1),
(47, 2, 16, 0),
(48, 3, 16, 0),
(49, 1, 17, 1),
(50, 2, 17, 0),
(51, 3, 17, 0),
(52, 1, 18, 1),
(53, 2, 18, 0),
(54, 3, 18, 0),
(55, 1, 19, 1),
(56, 2, 19, 0),
(57, 3, 19, 0),
(58, 1, 20, 1),
(59, 2, 20, 0),
(60, 3, 20, 0),
(61, 1, 21, 1),
(62, 2, 21, 0),
(63, 3, 21, 0),
(64, 1, 22, 1),
(65, 2, 22, 0),
(66, 3, 22, 0),
(67, 1, 23, 1),
(68, 2, 23, 0),
(69, 3, 23, 0),
(70, 1, 24, 1),
(71, 2, 24, 0),
(72, 3, 24, 0),
(73, 1, 25, 1),
(74, 2, 25, 0),
(75, 3, 25, 0),
(76, 1, 26, 1),
(77, 2, 26, 0),
(78, 3, 26, 0),
(79, 1, 27, 1),
(80, 2, 27, 0),
(81, 3, 27, 0),
(82, 1, 28, 1),
(83, 2, 28, 0),
(84, 3, 28, 0),
(85, 1, 29, 1),
(86, 2, 29, 0),
(87, 3, 29, 0),
(88, 1, 30, 1),
(89, 2, 30, 0),
(90, 3, 30, 0),
(91, 1, 31, 1),
(92, 2, 31, 0),
(93, 3, 31, 0),
(94, 1, 32, 1),
(95, 2, 32, 0),
(96, 3, 32, 0),
(97, 1, 33, 1),
(98, 2, 33, 0),
(99, 3, 33, 0),
(100, 1, 34, 1),
(101, 2, 34, 0),
(102, 3, 34, 0),
(103, 1, 35, 1),
(104, 2, 35, 0),
(105, 3, 35, 0),
(106, 1, 36, 1),
(107, 2, 36, 0),
(108, 3, 36, 0),
(109, 1, 37, 1),
(110, 2, 37, 0),
(111, 3, 37, 0),
(112, 1, 38, 1),
(113, 2, 38, 0),
(114, 3, 38, 0),
(115, 1, 39, 1),
(116, 2, 39, 0),
(117, 3, 39, 0),
(118, 1, 40, 1),
(119, 2, 40, 0),
(120, 3, 40, 0),
(121, 1, 41, 1),
(122, 2, 41, 0),
(123, 3, 41, 0),
(124, 1, 42, 1),
(125, 2, 42, 0),
(126, 3, 42, 0),
(127, 1, 43, 1),
(128, 2, 43, 0),
(129, 3, 43, 0),
(130, 1, 44, 1),
(131, 2, 44, 0),
(132, 3, 44, 0),
(133, 1, 45, 1),
(134, 2, 45, 0),
(135, 3, 45, 0),
(136, 1, 46, 1),
(137, 2, 46, 0),
(138, 3, 46, 0),
(139, 1, 47, 1),
(140, 2, 47, 0),
(141, 3, 47, 0),
(142, 1, 48, 1),
(143, 2, 48, 0),
(144, 3, 48, 0),
(145, 1, 49, 1),
(146, 2, 49, 0),
(147, 3, 49, 0),
(148, 1, 50, 1),
(149, 2, 50, 0),
(150, 3, 50, 0),
(151, 1, 51, 1),
(152, 2, 51, 0),
(153, 3, 51, 0),
(154, 1, 52, 1),
(155, 2, 52, 0),
(156, 3, 52, 0),
(157, 1, 53, 1),
(158, 2, 53, 0),
(159, 3, 53, 0),
(160, 1, 54, 1),
(161, 2, 54, 0),
(162, 3, 54, 0),
(163, 1, 55, 1),
(164, 2, 55, 0),
(165, 3, 55, 0),
(166, 1, 56, 1),
(167, 2, 56, 0),
(168, 3, 56, 0),
(169, 1, 57, 1),
(170, 2, 57, 0),
(171, 3, 57, 0),
(172, 1, 58, 1),
(173, 2, 58, 0),
(174, 3, 58, 0),
(175, 1, 59, 1),
(176, 2, 59, 0),
(177, 3, 59, 0),
(178, 1, 60, 1),
(179, 2, 60, 0),
(180, 3, 60, 0),
(181, 1, 61, 1),
(182, 2, 61, 0),
(183, 3, 61, 0),
(184, 1, 62, 1),
(185, 2, 62, 0),
(186, 3, 62, 0),
(187, 1, 63, 1),
(188, 2, 63, 0),
(189, 3, 63, 0),
(190, 1, 64, 1),
(191, 2, 64, 0),
(192, 3, 64, 0),
(193, 1, 65, 1),
(194, 2, 65, 0),
(195, 3, 65, 0),
(196, 1, 66, 1),
(197, 2, 66, 0),
(198, 3, 66, 0),
(199, 1, 67, 1),
(200, 2, 67, 0),
(201, 3, 67, 0),
(202, 1, 68, 1),
(203, 2, 68, 0),
(204, 3, 68, 0),
(205, 1, 69, 1),
(206, 2, 69, 0),
(207, 3, 69, 0),
(208, 1, 70, 1),
(209, 2, 70, 0),
(210, 3, 70, 0),
(211, 1, 71, 1),
(212, 2, 71, 0),
(213, 3, 71, 0),
(214, 1, 72, 1),
(215, 2, 72, 0),
(216, 3, 72, 0),
(217, 1, 73, 1),
(218, 2, 73, 0),
(219, 3, 73, 0),
(220, 1, 74, 1),
(221, 2, 74, 0),
(222, 3, 74, 0),
(223, 1, 75, 1),
(224, 2, 75, 0),
(225, 3, 75, 0),
(226, 1, 76, 1),
(227, 2, 76, 0),
(228, 3, 76, 0),
(229, 1, 77, 1),
(230, 2, 77, 0),
(231, 3, 77, 0),
(232, 1, 78, 1),
(233, 2, 78, 0),
(234, 3, 78, 0),
(235, 1, 79, 1),
(236, 2, 79, 0),
(237, 3, 79, 0),
(238, 1, 80, 1),
(239, 2, 80, 0),
(240, 3, 80, 0),
(241, 1, 81, 1),
(242, 2, 81, 0),
(243, 3, 81, 0),
(244, 1, 82, 1),
(245, 2, 82, 0),
(246, 3, 82, 0),
(247, 1, 83, 1),
(248, 2, 83, 0),
(249, 3, 83, 0),
(250, 1, 84, 1),
(251, 2, 84, 0),
(252, 3, 84, 0),
(253, 1, 85, 1),
(254, 2, 85, 0),
(255, 3, 85, 0),
(256, 1, 86, 1),
(257, 2, 86, 0),
(258, 3, 86, 0),
(259, 1, 87, 1),
(260, 2, 87, 0),
(261, 3, 87, 0),
(262, 1, 88, 1),
(263, 2, 88, 0),
(264, 3, 88, 0),
(265, 1, 89, 1),
(266, 2, 89, 0),
(267, 3, 89, 0),
(268, 1, 90, 1),
(269, 2, 90, 0),
(270, 3, 90, 0),
(271, 1, 91, 1),
(272, 2, 91, 0),
(273, 3, 91, 0),
(274, 1, 92, 1),
(275, 2, 92, 0),
(276, 3, 92, 0),
(277, 1, 93, 1),
(278, 2, 93, 0),
(279, 3, 93, 0),
(280, 1, 94, 1),
(281, 2, 94, 0),
(282, 3, 94, 0),
(283, 1, 95, 1),
(284, 2, 95, 0),
(285, 3, 95, 0),
(286, 1, 96, 1),
(287, 2, 96, 0),
(288, 3, 96, 0),
(289, 1, 97, 1),
(290, 2, 97, 0),
(291, 3, 97, 0),
(292, 1, 98, 1),
(293, 2, 98, 0),
(294, 3, 98, 0),
(295, 1, 99, 1),
(296, 2, 99, 0),
(297, 3, 99, 0),
(298, 1, 100, 1),
(299, 2, 100, 0),
(300, 3, 100, 0),
(301, 1, 101, 1),
(302, 2, 101, 0),
(303, 3, 101, 0),
(304, 1, 102, 1),
(305, 2, 102, 0),
(306, 3, 102, 0),
(307, 1, 103, 1),
(308, 2, 103, 0),
(309, 3, 103, 0),
(310, 1, 104, 1),
(311, 2, 104, 0),
(312, 3, 104, 0),
(313, 1, 105, 1),
(314, 2, 105, 0),
(315, 3, 105, 0),
(316, 1, 106, 1),
(317, 2, 106, 0),
(318, 3, 106, 0),
(319, 1, 107, 1),
(320, 2, 107, 0),
(321, 3, 107, 0),
(322, 1, 108, 1),
(323, 2, 108, 0),
(324, 3, 108, 0),
(325, 1, 109, 1),
(326, 2, 109, 0),
(327, 3, 109, 0),
(328, 1, 110, 1),
(329, 2, 110, 0),
(330, 3, 110, 0),
(331, 1, 111, 1),
(332, 2, 111, 0),
(333, 3, 111, 0),
(334, 1, 112, 1),
(335, 2, 112, 0),
(336, 3, 112, 0),
(337, 1, 113, 1),
(338, 2, 113, 0),
(339, 3, 113, 0),
(340, 1, 114, 1),
(341, 2, 114, 0),
(342, 3, 114, 0),
(343, 1, 115, 1),
(344, 2, 115, 0),
(345, 3, 115, 0),
(346, 1, 116, 1),
(347, 2, 116, 0),
(348, 3, 116, 0),
(349, 1, 117, 1),
(350, 2, 117, 0),
(351, 3, 117, 0),
(352, 1, 118, 1),
(353, 2, 118, 0),
(354, 3, 118, 0),
(355, 1, 119, 1),
(356, 2, 119, 0),
(357, 3, 119, 0),
(358, 1, 120, 1),
(359, 2, 120, 0),
(360, 3, 120, 0),
(361, 1, 121, 1),
(362, 2, 121, 0),
(363, 3, 121, 0),
(364, 1, 122, 1),
(365, 2, 122, 0),
(366, 3, 122, 0),
(367, 1, 123, 1),
(368, 2, 123, 0),
(369, 3, 123, 0),
(370, 1, 124, 1),
(371, 2, 124, 0),
(372, 3, 124, 0),
(373, 1, 125, 1),
(374, 2, 125, 0),
(375, 3, 125, 0),
(376, 1, 126, 1),
(377, 2, 126, 0),
(378, 3, 126, 0),
(379, 1, 127, 1),
(380, 2, 127, 0),
(381, 3, 127, 0),
(382, 1, 128, 1),
(383, 2, 128, 0),
(384, 3, 128, 0),
(385, 1, 129, 1),
(386, 2, 129, 0),
(387, 3, 129, 0),
(388, 1, 130, 1),
(389, 2, 130, 0),
(390, 3, 130, 0),
(391, 1, 131, 1),
(392, 2, 131, 0),
(393, 3, 131, 0),
(394, 1, 132, 1),
(395, 2, 132, 0),
(396, 3, 132, 0),
(397, 1, 133, 1),
(398, 2, 133, 0),
(399, 3, 133, 0),
(400, 1, 134, 1),
(401, 2, 134, 0),
(402, 3, 134, 0),
(403, 1, 135, 1),
(404, 2, 135, 0),
(405, 3, 135, 0),
(406, 1, 136, 1),
(407, 2, 136, 0),
(408, 3, 136, 0),
(409, 1, 137, 1),
(410, 2, 137, 0),
(411, 3, 137, 0),
(412, 1, 138, 1),
(413, 2, 138, 0),
(414, 3, 138, 0),
(415, 1, 139, 1),
(416, 2, 139, 0),
(417, 3, 139, 0),
(418, 1, 140, 1),
(419, 2, 140, 0),
(420, 3, 140, 0),
(421, 1, 141, 1),
(422, 2, 141, 0),
(423, 3, 141, 0),
(424, 1, 142, 1),
(425, 2, 142, 0),
(426, 3, 142, 0),
(427, 1, 143, 1),
(428, 2, 143, 0),
(429, 3, 143, 0),
(430, 1, 144, 1),
(431, 2, 144, 0),
(432, 3, 144, 0),
(433, 1, 145, 1),
(434, 2, 145, 0),
(435, 3, 145, 0),
(436, 1, 146, 1),
(437, 2, 146, 0),
(438, 3, 146, 0),
(439, 1, 147, 1),
(440, 2, 147, 0),
(441, 3, 147, 0),
(442, 1, 148, 1),
(443, 2, 148, 0),
(444, 3, 148, 0),
(445, 1, 149, 1),
(446, 2, 149, 0),
(447, 3, 149, 0),
(448, 1, 150, 1),
(449, 2, 150, 0),
(450, 3, 150, 0),
(451, 1, 151, 1),
(452, 2, 151, 0),
(453, 3, 151, 0),
(454, 1, 152, 1),
(455, 2, 152, 0),
(456, 3, 152, 0),
(457, 1, 153, 1),
(458, 2, 153, 0),
(459, 3, 153, 0),
(460, 1, 154, 1),
(461, 2, 154, 0),
(462, 3, 154, 0),
(463, 1, 155, 1),
(464, 2, 155, 0),
(465, 3, 155, 0),
(466, 1, 156, 1),
(467, 2, 156, 0),
(468, 3, 156, 0),
(469, 1, 157, 1),
(470, 2, 157, 0),
(471, 3, 157, 0),
(472, 1, 158, 1),
(473, 2, 158, 0),
(474, 3, 158, 0),
(475, 1, 159, 1),
(476, 2, 159, 0),
(477, 3, 159, 0),
(478, 1, 160, 1),
(479, 2, 160, 0),
(480, 3, 160, 0),
(481, 1, 161, 1),
(482, 2, 161, 0),
(483, 3, 161, 0),
(484, 1, 162, 1),
(485, 2, 162, 0),
(486, 3, 162, 0),
(487, 1, 163, 1),
(488, 2, 163, 0),
(489, 3, 163, 0),
(490, 1, 164, 1),
(491, 2, 164, 1),
(492, 3, 164, 1),
(493, 1, 165, 0),
(494, 2, 165, 0),
(495, 3, 165, 0),
(496, 1, 166, 0),
(497, 2, 166, 0),
(498, 3, 166, 0),
(499, 1, 167, 0),
(500, 2, 167, 0),
(501, 3, 167, 0),
(502, 1, 168, 0),
(503, 2, 168, 0),
(504, 3, 168, 0),
(505, 1, 169, 0),
(506, 2, 169, 0),
(507, 3, 169, 0),
(508, 1, 170, 0),
(509, 2, 170, 0),
(510, 3, 170, 0),
(511, 1, 171, 0),
(512, 2, 171, 0),
(513, 3, 171, 0),
(514, 1, 172, 0),
(515, 2, 172, 0),
(516, 3, 172, 0),
(517, 1, 173, 1),
(518, 2, 173, 0),
(519, 3, 173, 0),
(520, 1, 174, 1),
(521, 2, 174, 0),
(522, 3, 174, 0),
(523, 1, 175, 1),
(524, 2, 175, 0),
(525, 3, 175, 0),
(526, 1, 176, 1),
(527, 2, 176, 0),
(528, 3, 176, 0),
(529, 1, 177, 1),
(530, 2, 177, 0),
(531, 3, 177, 0),
(532, 1, 178, 1),
(533, 2, 178, 0),
(534, 3, 178, 0),
(535, 1, 179, 1),
(536, 2, 179, 0),
(537, 3, 179, 0),
(538, 1, 180, 1),
(539, 2, 180, 0),
(540, 3, 180, 0),
(541, 1, 181, 1),
(542, 2, 181, 0),
(543, 3, 181, 0),
(544, 1, 182, 1),
(545, 2, 182, 0),
(546, 3, 182, 0),
(547, 1, 183, 1),
(548, 2, 183, 0),
(549, 3, 183, 0),
(550, 1, 184, 1),
(551, 2, 184, 0),
(552, 3, 184, 0),
(553, 1, 185, 1),
(554, 2, 185, 0),
(555, 3, 185, 0),
(556, 1, 186, 1),
(557, 2, 186, 0),
(558, 3, 186, 0),
(559, 1, 187, 1),
(560, 2, 187, 0),
(561, 3, 187, 0),
(562, 1, 188, 1),
(563, 2, 188, 0),
(564, 3, 188, 0),
(565, 1, 189, 1),
(566, 2, 189, 0),
(567, 3, 189, 0),
(568, 1, 190, 1),
(569, 2, 190, 0),
(570, 3, 190, 0),
(571, 1, 191, 1),
(572, 2, 191, 1),
(573, 3, 191, 1),
(574, 1, 192, 1),
(575, 2, 192, 0),
(576, 3, 192, 0),
(577, 1, 193, 1),
(578, 2, 193, 0),
(579, 3, 193, 0);

-- --------------------------------------------------------

--
-- Table structure for table `core_alias`
--

CREATE TABLE `core_alias` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `depth` tinyint(3) NOT NULL COMMENT 'Number of url parts separated by slashes',
  `source_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0: source url will not work (no duplicates); 1: source url will work'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `core_alias` (`id`, `resource_id`, `source`, `alias`, `depth`, `source_status`) VALUES
(1, 191, '/page/view/1', '/fp', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `core_block`
--

CREATE TABLE `core_block` (
  `id` tinyint(3) NOT NULL,
  `block_code` varchar(30) NOT NULL COMMENT 'Usually same as source module item code e.g. mainMenu',
  `building_module` varchar(30) NOT NULL,
  `display_method` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `region_code` varchar(30) NOT NULL,
  `rank` tinyint(3) NOT NULL COMMENT 'Order of blocks in region',
  `uri` varchar(60) NOT NULL COMMENT 'Path to some custom block building Class, which is not located in GlobalCore module code. Uri is meaning here shortly unique resource identifier. In current context and system uri is not referring to some strict worldwide standard.',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0: not in use (passive); 1: in use (active)',
  `language_code` varchar(15) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_block`
--

INSERT INTO `core_block` (`id`, `block_code`, `building_module`, `display_method`, `type`, `region_code`, `rank`, `uri`, `status`, `language_code`) VALUES
(1, 'appUserArea', 'GlobalCore', 'buildUserBlock', 'User', 'userArea', 1, '', 0, 'en'),
(2, 'coreFrontPage', 'GlobalCore', 'getFrontPage', 'coreFrontPage', 'frontPage', 1, '', 0, 'en'),
(3, 'coreFooterArea', 'GlobalCore', 'buildFooterArea', 'footerArea', 'footerArea', 1, '', 1, 'en'),
(4, 'adminGeneralMenu', 'GlobalCore', 'buildMenuBlock', 'Menu', 'menuArea', 1, '', 1, 'en'),
(5, 'consentMessage', 'GlobalObserver', 'index', 'GlobalObserver', 'consentArea', 1, '', 1, 'en'),
(6, 'adminUserMenu', 'GlobalCore', 'buildMenuBlock', 'Menu', 'menuArea', 1, '', 1, 'en'),
(7, 'myAccount', 'GlobalCore', 'buildMenuBlock', 'Menu', 'menuArea', 1, '', 0, 'en'),
(8, 'userBlock', 'GlobalCore', 'buildUserBlock', 'uriBased', 'userArea', 11, 'modules/User/Model/UserBlocks.php', 1, 'en');

-- --------------------------------------------------------

--
-- Table structure for table `core_caching`
--

CREATE TABLE `core_caching` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL DEFAULT '0',
  `role_id` smallint(5) NOT NULL DEFAULT '2',
  `cache_content` longtext NOT NULL,
  `last_change_time` int(11) NOT NULL DEFAULT '0' COMMENT 'Timestamp for last change (for last time, when cache_content was rewritten)',
  `period` mediumint(7) NOT NULL DEFAULT '0' COMMENT 'Changing period in seconds (when cache_content will be rewritten)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `core_config`
--

CREATE TABLE `core_config` (
  `id` smallint(5) NOT NULL,
  `module_name` varchar(30) NOT NULL,
  `description` varchar(510) NOT NULL DEFAULT '',
  `uri` varchar(60) NOT NULL DEFAULT '' COMMENT 'Uri is meaning here shortly unique resource identifier. In current context and system uri is not referring to some strict worldwide standard.',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT 'Type can be used to group config entries or for other purposes.',
  `value` varchar(2000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_config`
--

INSERT INTO `core_config` (`id`, `module_name`, `description`, `uri`, `type`, `value`) VALUES
(1, 'GlobalCore', 'Site wide cache expiring period in minutes. The initial cache expiring period is determined in root directory in file config.php. If current config value is set (is an integer value), then it overwrites the period value, which is determined in config.php file.', 'cachePeriod', 'Caching', '60'),
(2, 'GlobalCore', 'Site wide default tags inside html head tag.', 'headTags', 'ThemeHead', '<script type=\"text/javascript\" src=\"[baseUrl]/misc/vendor/jquery/jquery-3.4.1.slim.min.js\"></script><script type=\"text/javascript\" src=\"[baseUrl]/misc/vendor/jquery/jquery-ui-1.12.1.custom/jquery-ui.js\"></script>\n'),
(3, 'GlobalCore', 'Site wide default other group 1 custom tags, which can be used inside html head or body tag (e.g. additional meta tags or some search engine tracking script tag). If value is [off], then no resources will be used to search for such tags.', 'otherTags1', 'Theme', ''),
(4, 'GlobalCore', 'Site wide default other group 2 custom tags, which can be used inside html head or body tag (e.g. some search engine tracking script tag). If value is [off], then no resources will be used to search for such tags.', 'otherTags2', 'Theme', ''),
(5, 'GlobalCore', 'Default site wide description. Use in value field meta tag format: <meta name=\"description\" content=\"[Your description here without square brackets]\">. If value is empty, then no description tag will be added.', 'metaDescription', 'ThemeHead', ''),
(6, 'GlobalCore', 'Path, that determines the location of favicon.ico image file for the website. E.g. [baseUrl]/misc/input/themes/default/favicon.ico. If value is empty, then no favicon tag will be used. Example value: [baseUrl]/misc/input/themes/default/favicon.ico.', 'faviconPath', 'ThemeHead', ''),
(7, 'GlobalCore', 'Custom configuration option, which can be used in themes. If value is empty, then no custom configuration will be used.', 'customValue', 'ThemeBody', ''),
(8, 'GlobalCore', 'Link tag for favicon. E.g. &lt;link rel=&quot;shortcut icon&quot; href=&quot;[baseUrl]/misc/input/themes/default/favicon.ico&quot;&gt;', 'faviconImage', 'ThemeHead', ''),
(9, 'GlobalCore', 'Logo image tag for common theme cases. If this value is empty, then no logo image will be used. E.g. &lt;img src=\"[baseUrl]/misc/input/themes/default/new-website-logo.png\" alt=\"[siteName] Logo\" width=\"60\" height=\"60\"&gt;', 'logoImage', 'ThemeBody', ''),
(10, 'GlobalCore', 'Second logo image tag for cases whenever two logo images are needed at the same time. It can be used for example for mobile-friendly theme views. If this value is empty, then no second logo image will be used. E.g. &lt;img src=\"[baseUrl]/misc/input/themes/default/new-website-logo-mobile.png\" alt=\"[siteName] Logo\" width=\"48\" height=\"48\"&gt;', 'smallLogoImage', 'ThemeBody', ''),
(11, 'GlobalCore', 'Site name image tag, which would replace site name as text. If this config value is empty, then site name as text will be used. Example value: &lt;img src=\"[baseUrl]/misc/input/themes/default/new-website-name.png\" alt=\"[siteName]\"  class=\"site-name-image\"&gt;.', 'siteNameImage', 'ThemeBody', ''),
(12, 'GlobalCore', 'Second site name image tag, which would replace site name as text. It can be used for example for mobile-friendly theme views. If this config value is empty, then site name as text will be used. Example value: &lt;img src=\"[baseUrl]/misc/input/themes/default/new-website-name-mobile.png\" alt=\"[siteName]\"  class=\"site-name-image\"&gt;.', 'smallSiteNameImage', 'ThemeBody', ''),
(13, 'GlobalCore', 'Site wide default footer area content. E.g. &#39;Copyright [Year] by Your Company Name LTD&#39;. Token [Year] is a place holder, which will be automatically replaced by current year.', 'coreFooterArea', 'ThemeBody', '<a href=\"http://www.allmice.com/cms\">Powered by Allmice CMS (www.allmice.com/cms)</a>'),
(14, 'GlobalCore', 'Site wide main language codes. Config value format is \"code;code2\". Code part of the format is meaning usually two digit ISO 639-1 code for HTML tags. Code2 part of the format is meaning other more specific language code to distinguish different language dialects. E.g. IETF code en-GB for British English. If there is no need to use such specific language code, then code2 should be equal to code.', 'mainLanguage', 'Language', 'en;en'),
(15, 'GlobalCore', 'Site wide default language data. This data overwrites the mainLanguage config entry for roles specified here. Config value format is \"code;code2;role-1[;...;role-n]\". Code part of the format is meaning usually two digit ISO 639-1 code for HTML tags. Code2 part of the format is meaning other more specific language code to distinguish different language dialects. E.g. IETF code en-GB for British English. If there is no need to use such specific language code, then code2 should be equal to code.', 'defaultLanguage', 'Language', 'en;en;anonymous'),
(16, 'App', 'Choose whether to show or not paginator widget. Possible options are: on, off or onDemand. The option onDemand is meaning that the widget will be shown only if there are several result pages (more than one).', 'displayPaginatorSwitch', 'paginator', 'onDemand'),
(17, 'App', 'Maximum number of items on page.', 'itemsOnPage', 'paginator', '20'),
(18, 'App', 'Maximum number of page ranges in the drop-down list.', 'maxRanges', 'paginator', '30'),
(19, 'App', 'Turns alias functionality for every entry on or off.', 'aliasCheckSwitch', 'paginator', 'on'),
(20, 'App', 'This configuration value determines how to display paginator search result for content, for which current user role has no access right. Possible values are skip, skip&order, empty and full. Value skip will not show the result without access right at all; empty shows such result as empty rows; full shows it in the same way as other result, but clicking on link user would still not see the content; skip&order (or any unknown value) is similar to skip, but supports ordering search content.', 'accessRightMethod', 'paginator', 'skip&order'),
(21, 'App', 'Choose whether to show or not captcha widget. Possible values on or off. If the value is off, then form submission against bots is still protected by checking a session value.', 'displayWidgetSwitch', 'captcha', 'on'),
(22, 'App', 'Cipher method for openssl_encrypt function. Different PHP versions may not support the same cipher method. If this value is not a supported cipher method, then captcha widget will not be used, but there will still be a session value checking protection.', 'method', 'captcha', 'aes-256-ctr'),
(23, 'App', 'Secret key string to encrypt the captcha code for the url query part of images.', 'key', 'captcha', ''),
(24, 'App', 'Another secret value. If openssl_encrypt PHP function will be used, then this is iv (Initialization Vector) parameter, which length may be different in case of different cipher methods. If this value is empty, then iv parameter will not be used.', 'key2', 'captcha', 'agTn0IsEbaF4kZa3'),
(25, 'App', 'Width of captcha image.', 'width', 'captcha', '160'),
(26, 'App', 'Height of captcha image.', 'height', 'captcha', '60'),
(27, 'App', 'Angle of captcha text.', 'angle', 'captcha', '10'),
(28, 'App', 'Font size of captcha text.', 'fontSize', 'captcha', '0'),
(29, 'App', 'Text color for captcha image as six digit hexadecimal color code.', 'textColor', 'captcha', '#646464'),
(30, 'App', 'Background noise color for captcha image as six digit hexadecimal color code.', 'noiseColor', 'captcha', '#AFAFAF'),
(31, 'App', 'Background color for captcha image as six digit hexadecimal color code.', 'bgColor', 'captcha', '#FFFFFF'),
(32, 'App', 'Path for font, which will be used to draw text to the captcha image.', 'fontPath', 'captcha', '/usr/share/fonts/truetype/verdana/Verdana.ttf'),
(33, 'Admin', 'Form validation regular expression pattern for tiny integer text fields (e.g. rank number for sorting purposes).', 'tinyInt', 'formValidationRegEx', '/^[0-9]{0,3}$/'),
(34, 'Admin', 'Form validation regular expression pattern for unique resource identifier (uri) text fields (e.g. small path or just an unique code).', 'uri', 'formValidationRegEx', '/^[a-zA-Z0-9_\\-\\/]{0,60}$/'),
(35, 'Admin', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
(36, 'Admin', 'Form validation regular expression pattern for path text fields (e.g. url or some other long path).', 'path', 'formValidationRegEx', '/^[a-zA-Z0-9_\\-\\/]{0,255}$/'),
(37, 'Admin', 'Form validation regular expression pattern for small textarea fields (e.g. menu title for human).', 'smallTextarea', 'formValidationRegEx', '/^(.){0,510}$/'),
(38, 'Admin', 'Form validation regular expression pattern for medium textarea fields (e.g. description).', 'mediumTextarea', 'formValidationRegEx', '/^(.){0,2000}$/s'),
(39, 'Admin', 'Form validation regular expression pattern for username fields.', 'username', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,60}$/'),
(40, 'Admin', 'Form validation regular expression pattern for password fields.', 'password', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,255}$/'),
(41, 'Admin', 'Form validation regular expression pattern for e-mail fields.', 'email', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
(42, 'Block', 'Form validation regular expression pattern for tiny integer text fields (e.g. rank number for sorting purposes).', 'tinyInt', 'formValidationRegEx', '/^[0-9]{0,3}$/'),
(43, 'Block', 'Form validation regular expression pattern for unique resource identifier (uri) text fields (e.g. small path or just an unique code).', 'uri', 'formValidationRegEx', '/^[a-zA-Z0-9_\\-\\/.]{0,60}$/'),
(44, 'Block', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
(45, 'Menu', 'Form validation regular expression pattern for tiny integer text fields (e.g. rank number for sorting purposes).', 'tinyInt', 'formValidationRegEx', '/^[0-9]{0,3}$/'),
(46, 'Menu', 'Form validation regular expression pattern for unique resource identifier (uri) text fields (e.g. small path or just an unique code).', 'uri', 'formValidationRegEx', '/^(.*)$/'),
(47, 'Menu', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
(48, 'Menu', 'Form validation regular expression pattern for human readable short text fields.', 'text60', 'formValidationRegEx', '/^(.){0,60}$/'),
(49, 'FormField', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
(50, 'FormField', 'Form validation regular expression pattern for human readable medium text fields (maximum 250 characters).', 'text250', 'formValidationRegEx', '/^(.){0,250}$/'),
(51, 'FormField', 'Form validation regular expression pattern for tiny integer text fields (e.g. rank number for sorting purposes).', 'tinyInt', 'formValidationRegEx', '/^(.){0,3}$/'),
(52, 'GlobalObserver', 'Module switch, which allows to switch all observing functionality on or off. Possible values are \"on\" or \"off\".', 'moduleSwitch', 'general', 'off'),
(53, 'GlobalObserver', 'Consent signal getting method. Possible values are: using, continuing and submit. Caution: Archive existing data before changing this value!', 'consentMethod', 'consent', 'using'),
(54, 'GlobalObserver', 'Determines the method, how many times maximally browsing clicks will be saved into database and how many times message box will be shown, as long as message submit button has not been clicked. Possible values are notLimited and xTimes.', 'observingMethod', 'general', 'xTimes'),
(55, 'GlobalObserver', 'Determines the integer value, how many times maximally browsing clicks will be saved into database and how many times message box will be shown. This integer number will be used for counting, if observingMethod value is xTimes.', 'observingTimes', 'general', '5'),
(56, 'GlobalObserver', 'Parts of exceptional website addresses, separated by ;. The pages with a such url part, are considered as precondition for consent signal (not as part of giving consent). E.g. Reading Privacy Policy page can be a precondition before giving consent.', 'exUrlParts', 'general', '/terms;/contact;/opt-out-data;/privacy-and-cookies-policy'),
(57, 'GlobalObserver', 'Time unit. Possible values are: days, hours, minutes or seconds.', 'timeUnit', 'dataExpiry', 'days'),
(58, 'GlobalObserver', 'Time period (see also timeUnit), which determines, how often to delete older data. If value is 0, then never.', 'deletingFrequency', 'dataExpiry', '30'),
(59, 'GlobalObserver', 'Data expiring period for deleting (see also timeUnit), which determines, how old is data considered to be to delete it.', 'deletingExpiringPeriod', 'dataExpiry', '30'),
(60, 'GlobalObserver', 'Time period (see also timeUnit), which determines, how often to archive older data. If value is 0, then never.', 'archivingFrequency', 'dataExpiry', '30'),
(61, 'GlobalObserver', 'Data expiring period for archiving (see also timeUnit), which determines, how old is data considered to be to archived.', 'archivingExpiringPeriod', 'dataExpiry', '30'),
(62, 'GlobalObserver', 'Archiving location for older data. Provide a folder path and make sure, that this folder is writable for the web server software. If there is no value, then archiving will not be done.', 'archivingLocation', 'dataExpiry', ''),
(63, 'GlobalObserver', 'Observing will not be used for users with roles listed here. Separate the exceptional roles by commas and spaces. E.g. \"admin, authenticated\".', 'exceptionalRoles', 'general', 'admin'),
(64, 'GlobalObserver', 'Names of submit buttons, which will give consent signals. Commas and spaces are separating names. E.g. \"mesSubmit, register\". By clicking such button, an entry will be recorded into event table usually with type 10X, where X is 0-9, order of the name.', 'consentSubmitButtons', 'consent', 'mesSubmit, register'),
(65, 'GlobalObserver', 'Relative URL for Read more link, where Privacy Policy, use of cookies and other terms of use are described in more detail.', 'readMoreUrl', 'consent', '/terms'),
(66, 'Message', 'Mail server host name, which will be used to authenticate the outgoing by system generated e-mail.', 'host', 'emailAuthentication', 'smtp.gmail.com'),
(67, 'Message', 'Mail server port number, which will be used to authenticate the outgoing by system generated e-mail.', 'port', 'emailAuthentication', '587'),
(68, 'Message', 'Mail account username, which will be used to authenticate the outgoing by system generated e-mail.', 'username', 'emailAuthentication', ''),
(69, 'Message', 'Mail account password, which will be used to authenticate the outgoing by system generated e-mail.', 'password', 'emailAuthentication', ''),
(70, 'Message', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
(71, 'Message', 'Form validation regular expression pattern for username fields.', 'username', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,60}$/'),
(72, 'Message', 'Form validation regular expression pattern for person name fields.', 'personName', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,120}$/'),
(73, 'Message', 'Form validation regular expression pattern for e-mail fields.', 'eMail', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
(74, 'Message', 'Form validation regular expression pattern for human readable medium text fields.', 'text255', 'formValidationRegEx', '/^(.){0,255}$/'),
(75, 'Message', 'Form validation regular expression pattern for medium textarea fields (e.g. description).', 'mediumTextarea', 'formValidationRegEx', '/^(.){0,2000}$/s'),
(76, 'Message', 'Timezone value for sending emails. See http://php.net/manual/en/timezones.php for correct values.', 'timezone', 'email', 'Europe/London'),
(77, 'Page', 'Default script tags for html head element in case of Page module events.', 'default', 'headTags', '<script type=\"text/javascript\" src=\"[baseUrl]/misc/vendor/jquery/jquery-3.4.1.slim.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"[baseUrl]/misc/vendor/jquery/jquery-ui-1.12.1.custom/jquery-ui.js\"></script>\r\n<script src=\"[baseUrl]/modules/Page/config/vendor/ckeditor/ckeditor.js\"></script>\r\n<script type=\"text/javascript\">\r\n$(document).ready(function(){\r\n \r\n	$(\".slidingDiv\").show();\r\n	$(\".show_hide\").show();\r\n	 \r\n	$(\'.show_hide\').click(function(){\r\n		$(\".slidingDiv\").slideToggle();\r\n	});\r\n \r\n});\r\n</script>\r\n'),
(78, 'Page', 'Default script tags for html head element in case of Page module view event. If place holder [none] is used, then this tag will be omitted', 'view', 'headTags', '[none]'),
(79, 'Page', 'If set, then finds class and method, that will be used to build front page.', 'modules/Page/Model/FrontPage.php', 'frontPage', 'FrontPage/buildFrontPage/1'),
(80, 'Page', 'Template (html code with placeholders), that determines, which components of the Page module regular page will be displayed and how.', 'pageView', 'viewTemplate', '[pdfData][editorData]<h1>[title]</h1>\r\n<div class=\"content-body\">\r\n[body]\r\n</div>'),
(81, 'Page', 'Template (html code with placeholders), that determines, which components of the Page module front page will be displayed and how.', 'frontpageView', 'viewTemplate', '<div class=\"content-body\">\r\n[body]\r\n</div>'),
(82, 'Page', 'Form validation regular expression pattern for email fields.', 'email', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
(83, 'Page', 'Form validation regular expression pattern for short text fields (e.g. page title for human).', 'shortText', 'formValidationRegEx', '/^(.){0,60}$/'),
(84, 'Page', 'Form validation regular expression pattern for small textarea fields (e.g. menu title for human).', 'smallTextarea', 'formValidationRegEx', '/^(.){0,250}$/'),
(85, 'Page', 'Form validation regular expression pattern for medium textarea fields (e.g. post submitting field).', 'mediumTextarea', 'formValidationRegEx', '/^(.){0,2040}$/s'),
(86, 'Page', 'Form validation regular expression pattern for large textarea fields (e.g. page body textarea).', 'largeTextarea', 'formValidationRegEx', '/^(.){0,1000000}$/s'),
(87, 'Page', 'Form validation regular expression pattern for path text fields (e.g. url or some other long path).', 'path', 'formValidationRegEx', '/^[a-zA-Z0-9_\\-\\/]{0,255}$/'),
(88, 'Page', 'Form validation regular expression pattern for small integer text fields (e.g. rank number for sorting purposes).', 'smallInt', 'formValidationRegEx', '/^[0-9]{0,5}$/'),
(89, 'Page', 'Form validation regular expression pattern for captcha text fields.', 'captcha', 'formValidationRegEx', '/^[a-zA-Z0-9]{0,10}$/'),
(90, 'Page', 'Inside snippet switch. Possible values on or off. Determines whether to look for snippet entries from database or not.', 'insideSnippetSwitch', 'viewEvent', 'off'),
(91, 'Page', 'Comment (post) switch. Possible values are on or off. Determines whether to look for posts (comments) from database or not.', 'commentSwitch', 'viewEvent', 'off'),
(92, 'Page', 'Location of the class, which will be used to add the posts to a specific page.', 'postClassLocation', 'viewEvent', 'modules/Page/Model/Post.php'),
(93, 'Page', 'Activate (on) or deactivate (off) the option, whether page creator or owner can choose role access right by adding a new page.', 'roleAccessSwitch', 'addPageEvent', 'on'),
(94, 'Page', 'Default roles, which will have access right for the new page. E.g. &quot;admin, authenticated&quot;. If role access form element is enabled (see roleAccessSwitch), then these roles are selected by default in this element.', 'defaultRoleAccess', 'addPageEvent', 'admin, authenticated, anonymous'),
(95, 'Page', 'Activate (on) or deactivate (off) the option, whether page creator or owner can choose role based caching by adding a new page.', 'roleCacheSwitch', 'addPageEvent', 'off'),
(96, 'Page', 'Default roles, for which the new page will be cached. E.g. &quot;admin, authenticated&quot; or empty if no roles chosen. If role caching form element is enabled (see roleCacheSwitch), then these roles are selected by default in this element.', 'defaultRoleCache', 'addPageEvent', ''),
(97, 'Page', 'Activate (on) or deactivate (off) the option, whether page creator or owner can choose bot tag by adding a new page.', 'botTagSwitch', 'addPageEvent', 'on'),
(98, 'Page', 'Default html bot tag integer identifier value. Possible values are between 1 to 5 meaning following: 1. No tag (html default - index, follow) 2. Noindex, nofollow 3. Noindex, follow 4. Index, nofollow, 5. Index, follow (with tag). If bot tag element is enabled (see botTagSwitch), then this value is selected by default in this element.', 'defaultBotTag', 'addPageEvent', '1'),
(99, 'Page', 'Roles, which can add comments to pages, if comment (post) switch is turned on.', 'commentRoleAccess', 'viewEvent', 'admin, authenticated'),
(100, 'Page', 'Template (html code with placeholders), that determines, which components of every Post item will be displayed and how.', 'postItemView', 'postTemplate', '&lt;div class=&quot;post-creating-data&quot;&gt;\r\n[creatorLabel] \r\n&lt;div class=&quot;post-creator-name&quot;&gt;\r\n[gravatar]\r\n[creatorName]\r\n&lt;/div&gt;\r\n&lt;div class=&quot;post-creating-time&quot;&gt;\r\n[creatingTime]\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n[editDataStart]\r\n&lt;div class=&quot;post-editing-data&quot;&gt;\r\n[editorLabel] \r\n&lt;div class=&quot;post-editor-name&quot;&gt;\r\n[editorName]\r\n&lt;/div&gt;\r\n&lt;div class=&quot;post-editing-time&quot;&gt;\r\n[editingTime]\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n[editDataEnd]\r\n&lt;div class=&quot;post-content&quot;&gt;\r\n[content]\r\n&lt;/div&gt;\r\n[editLink]\r\n'),
(101, 'Profile', 'Form validation regular expression pattern for e-mail fields.', 'email', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
(102, 'Profile', 'Form validation regular expression pattern for human readable medium text fields (maximum 250 characters).', 'text250', 'formValidationRegEx', '/^(.){0,250}$/'),
(103, 'Profile', 'Size of the image in pixels (width and height equal) for gravatar or sitewide avatar images.', 'avatarImageSize', 'indexEvent', '40'),
(104, 'Profile', 'Url for sitewide avatar image.', 'siteAvatarUrl', 'indexEvent', 'misc/input/allmice40.png'),
(105, 'Profile', 'Activate (on) or deactivate (off) the option, whether registered user can choose default language.', 'languageSwitch', 'indexEvent', 'off'),
(106, 'Profile', 'Default language, which will be associated with a registered user profile by default if user will not choose it.', 'defaultLanguage', 'indexEvent', 'en'),
(107, 'OwnPage', 'Default script tags for html head element in case of Page module events.', 'default', 'headTags', '<script type=\"text/javascript\" src=\"[baseUrl]/misc/vendor/jquery/jquery-3.4.1.slim.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"[baseUrl]/misc/vendor/jquery/jquery-ui-1.12.1.custom/jquery-ui.js\"></script>\r\n<script src=\"[baseUrl]/modules/Page/config/vendor/ckeditor/ckeditor.js\"></script>\r\n<script type=\"text/javascript\">\r\n$(document).ready(function(){\r\n \r\n	$(\".slidingDiv\").show();\r\n	$(\".show_hide\").show();\r\n	 \r\n	$(\'.show_hide\').click(function(){\r\n		$(\".slidingDiv\").slideToggle();\r\n	});\r\n \r\n});\r\n</script>\r\n'),
(108, 'OwnPage', 'Form validation regular expression pattern for email fields.', 'email', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
(109, 'OwnPage', 'Form validation regular expression pattern for short text fields (e.g. page title for human).', 'shortText', 'formValidationRegEx', '/^(.){0,60}$/'),
(110, 'OwnPage', 'Form validation regular expression pattern for small textarea fields (e.g. menu title for human).', 'smallTextarea', 'formValidationRegEx', '/^(.){0,250}$/'),
(111, 'OwnPage', 'Form validation regular expression pattern for medium textarea fields (e.g. post submitting field).', 'mediumTextarea', 'formValidationRegEx', '/^(.){0,2040}$/s'),
(112, 'OwnPage', 'Form validation regular expression pattern for large textarea fields (e.g. page body textarea).', 'largeTextarea', 'formValidationRegEx', '/^(.){0,1000000}$/s'),
(113, 'OwnPage', 'Form validation regular expression pattern for path text fields (e.g. url or some other long path).', 'path', 'formValidationRegEx', '/^[a-zA-Z0-9_\\-\\/]{0,255}$/'),
(114, 'OwnPage', 'Form validation regular expression pattern for small integer text fields (e.g. rank number for sorting purposes).', 'smallInt', 'formValidationRegEx', '/^[0-9]{0,5}$/'),
(115, 'OwnPage', 'Activate (on) or deactivate (off) the option, whether page creator or owner can change role access right for own pages while editing them.', 'roleAccessSwitch', 'editPageEvent', 'off'),
(116, 'OwnPage', 'Activate (on) or deactivate (off) the option, whether page creator or owner can change roles, for which the editable page will be cached.', 'roleCacheSwitch', 'editPageEvent', 'off'),
(117, 'OwnPage', 'Activate (on) or deactivate (off) the option, whether page creator or owner can choose bot tag by adding a new page.', 'botTagSwitch', 'editPageEvent', 'off'),
(118, 'User', 'Default active role for users, who will be added through signUpEvent.', 'signUpEvent', 'defaultMainRole', 'authenticated'),
(119, 'User', 'Default active role for users, who will be added through registerEvent.', 'registerEvent', 'defaultMainRole', 'authenticated'),
(120, 'User', 'Period in days, during which user messages will be kept in database table mod_user_message.', 'messageLifetime', 'period', '90'),
(121, 'User', 'Delay period in seconds, between new password requests, if memorable word is not set.', 'passwordRequestPeriod', 'recoverAccount', '21600'),
(122, 'User', 'Delay period in seconds, between new email verifying code requests.', 'verifyingCodePeriod', 'sendVerifyingCode', '21600'),
(123, 'User', 'Form validation regular expression pattern for code-name-identifier text fields (e.g. menu name for computer program purposes).', 'code', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,30}$/'),
(124, 'User', 'Form validation regular expression pattern for username fields.', 'username', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,60}$/'),
(125, 'User', 'Form validation regular expression pattern for person name fields.', 'personName', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,120}$/'),
(126, 'User', 'Form validation regular expression pattern for e-mail fields.', 'email', 'formValidationRegEx', '/^(.+@.+..+){0,120}$/'),
(127, 'User', 'Form validation regular expression pattern for phone fields.', 'phone', 'formValidationRegEx', '/^[0-9+-.() ]{0,30}$/'),
(128, 'User', 'Form validation regular expression pattern for phone fields.', 'postalCode', 'formValidationRegEx', '/^[A-Z0-9- .]{0,20}$/'),
(129, 'User', 'Form validation regular expression pattern for human readable small text fields (maximum 120 characters).', 'text125', 'formValidationRegEx', '/^(.){0,125}$/'),
(130, 'User', 'Form validation regular expression pattern for human readable medium text fields (maximum 250 characters).', 'text250', 'formValidationRegEx', '/^(.){0,250}$/'),
(131, 'User', 'Form validation regular expression pattern for password fields (maximum 255 characters).', 'password', 'formValidationRegEx', '/^[a-zA-Z0-9_]{0,255}$/'),
(132, 'User', 'Form validation regular expression pattern for medium textarea fields (e.g. description).', 'mediumTextarea', 'formValidationRegEx', '/^(.){0,2000}$/s'),
(133, 'User', 'Url link, which will be provided for agreement checkbox in User module signUp event form.', 'agreementLink', 'signUpView', '<a href=\"[baseUrl]/terms-of-service\" target=\"_blank\">[lang-agreementLink]</a>'),
(134, 'User', 'Url link, which will be provided on login pages to the register or sign up page. E.g. &lt;a href=\"[baseUrl]/user/sign-up\"&gt;[lang-registerLink]&lt;/a&gt;.', 'registerLink', 'loginView', ''),
(135, 'User', 'Url link, which will be provided on login pages to recover account (to get a new password, if it has been forgotten). E.g. &lt;a href=\"[baseUrl]/user/recover-account\"&gt;[lang-recoveryLink]&lt;/a&gt;.', 'recoveryLink', 'loginView', ''),
(136, 'User', 'Url link, which will be provided on login pages to the email verifying page. E.g. &lt;a href=\"[baseUrl]/user/send-verifying-code\"&gt;[lang-verifyLink]&lt;/a&gt;.', 'verifyLink', 'loginView', ''),
(137, 'User', 'Choose whether to show or not captcha widget. Possible values are on or off. If the value is off, then form submission against bots is still protected by checking a session value.', 'displayWidgetSwitch', 'captcha', 'on'),
(138, 'User', 'Cipher method for openssl_encrypt function. Different PHP versions may not support the same cipher method. If this value is not a supported cipher method, then captcha widget will not be used, but there will still be a session value checking protection.', 'method', 'captcha', 'aes-256-ctr'),
(139, 'User', 'Secret key string to encrypt the captcha code for the url query part of images.', 'key', 'captcha', ''),
(140, 'User', 'Another secret value. If openssl_encrypt PHP function will be used, then this is iv (Initialization Vector) parameter, which length may be different in case of different cipher methods. If this value is empty, then iv parameter will not be used.', 'key2', 'captcha', 'agTn0IsEbaF4kZa3'),
(141, 'User', 'Width of captcha image.', 'width', 'captcha', '160'),
(142, 'User', 'Height of captcha image.', 'height', 'captcha', '60'),
(143, 'User', 'Angle of captcha text.', 'angle', 'captcha', '10'),
(144, 'User', 'Font size of captcha text.', 'fontSize', 'captcha', '0'),
(145, 'User', 'Text color for captcha image as six digit hexadecimal color code.', 'textColor', 'captcha', '#646464'),
(146, 'User', 'Background noise color for captcha image as six digit hexadecimal color code.', 'noiseColor', 'captcha', '#AFAFAF'),
(147, 'User', 'Background color for captcha image as six digit hexadecimal color code.', 'bgColor', 'captcha', '#FFFFFF'),
(148, 'User', 'Path for font, which will be used to draw text to the captcha image.', 'fontPath', 'captcha', '/usr/share/fonts/truetype/verdana/Verdana.ttf'),
(149, 'Search', 'Form validation regular expression pattern for medium text fields (e.g. keywords for search).', 'mediumText', 'formValidationRegEx', '/^(.){0,120}$/'),
(150, 'Theme', 'Default script tags for html head element in case of Theme module events. If place holder [none] is used, then this tag will be omitted.', 'default', 'headTags', '<script src=\"[baseUrl]/misc/vendor/jquery/jquery-3.4.1.slim.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"[baseUrl]/modules/Theme/config/vendor/tinyColorPicker/colors.js\"></script>\r\n<script type=\"text/javascript\" src=\"[baseUrl]/modules/Theme/config/vendor/tinyColorPicker/jqColorPicker.js\"></script>\r\n'),
(151, 'User', 'Configurable part for html head element in case of User module contactForm event. If place holder [none] is used, then this config will not be used.', 'contactForm', 'headTags', '<meta name=\"robots\" content=\"noindex, nofollow\">'),
(152, 'GlobalCore', 'Session inactivity lifetime in minutes. The initial value is determined in root directory in file config.php. If current config value is set (is an integer value), then it overwrites the value, which is determined in config.php file.', 'sessLifetime', 'Session', '120'),
(153, 'GlobalCore', 'Database cleaning period of session entries in days. The initial value is determined in root directory in file config.php. If current config value is set (is an integer value), then it overwrites the value, which is determined in config.php file.', 'dbCleaningPeriod', 'Session', '30'),
(154, 'GlobalCore', 'Site wide main date format (see also mainTimeFormat). Suggested to use for main language. To understand how to change the value, see the URL http://php.net/manual/en/datetime.formats.date.php. The default date was chosen according to ISO 8601 standard.', 'mainDateFormat', 'Language', 'Y-m-d'),
(155, 'GlobalCore', 'Site wide main time format (see also mainDateFormat). Suggested to use for main language. To understand how to change the value, see the URL http://php.net/manual/en/datetime.formats.date.php. The default date was chosen according to ISO 8601 standard.', 'mainTimeFormat', 'Language', 'Y-m-d H:i'),
(156, 'GlobalCore', 'Site wide default date format (see also defaultTimeFormat). Suggested to use for default language. This value overwrites corresponding main format. To understand how to change the value, see the URL http://php.net/manual/en/datetime.formats.date.php. The default date was chosen according to ISO 8601 standard.', 'defaultDateFormat', 'Language', 'Y-m-d'),
(157, 'GlobalCore', 'Site wide default time format (see also defaultDateFormat). Suggested to use for default language. This value overwrites corresponding main format. To understand how to change the value, see the URL http://php.net/manual/en/datetime.formats.date.php. The default date was chosen according to ISO 8601 standard.', 'defaultTimeFormat', 'Language', 'Y-m-d H:i'),
(158, 'GlobalCore', 'Site wide main time format without date (see also mainTimeFormat). Suggested to use for main language. To understand how to change the value, see the URL http://php.net/manual/en/datetime.formats.date.php. The default date was chosen according to ISO 8601 standard.', 'mainShortTimeFormat', 'Language', 'H:i'),
(159, 'GlobalCore', 'Site wide default time format without date (see also defaultTimeFormat). Suggested to use for default language. This value overwrites corresponding main format. To understand how to change the value, see the URL http://php.net/manual/en/datetime.formats.date.php.', 'defaultShortTimeFormat', 'Language', 'H:i'),
(160, 'Search', 'This configuration value determines, which search type will be used for search block. The value should be in format "table_name, field_name" to find the search type id.', 'searchType', 'searchBlock', 'mod_page, body'),
(161, 'Page', 'Template to create title tag content. Two tokens can be used: [title] - the text in the title form field when adding or editing a page (this title is also used in h1 tag); [siteName] - site name.', 'titleTagTemplate', 'viewEvent', '[title] | [siteName]'),
(162, 'Search', 'This configuration value determines, how the search result will be displayed in list. Possible values are table and list. Table is more traditional mode; list is more smart-device-friendly mode, where search result columns are displayed in rows.', 'listMode', 'searchResult', 'list'),
(163, 'Search', 'Custom file path to view Search module list-by-type method page. E.g. custom/templates/search/list-by-type.phtml. If this value is empty or the file does not exist, then no custom file will be used.', 'viewPath', 'listByTypeEvent', ''),
(164, 'Page', 'Settings to customize the pdf output of the third party PHP library (TCPDF). These settings are relevant, if config entry headerFooterDisplayMode value is Tcpdf. Some of these settings will also be used as default, when that mode is HtmlCss (the styles config entries in such mode would overwrite the default settings here). These settings are lines of key value pairs separated by equal sign (=) and are helping easier to integrate TCPDF library with Allmice CMS.', 'tcpdfVariousSettings', 'viewPdfEvent', 'fontFamily=helvetica\r\nfontStyle=\r\nfontSize=10\r\ntopMargin=32\r\ntopMargin=26\r\nbottomMargin=16\r\nleftMargin=15\r\nrightMargin=15\r\nheaderLogoFormat=PNG\r\nheaderLogoWidth=10\r\nheaderLogoHorizontalAlign=L\r\nheaderLogoVerticalAlign=M\r\nheaderLogoPath=misc/input/allmice80.png\r\nheaderLogoLeft=0\r\nheaderLogoTop=6\r\nheaderFontFamily=helvetica\r\nheaderFontStyle=\r\nheaderFontSize=14\r\nheaderTextCellWidth=0\r\nheaderTextCellHeight=20\r\nheaderTextHorizontalAlign=C\r\nheaderTextVerticalAlign=M\r\nheaderCellVerticalAlign=M\r\nheaderPositionFromTop=10\r\nheaderPositionFromTop=5\r\nheaderPositionFromLeft=0\r\nfooterFontFamily=helvetica\r\nfooterFontStyle=\r\nfooterFontSize=10\r\nfooterTextCellWidth=0\r\nfooterTextCellHeight=10\r\nfooterTextHorizontalAlign=C\r\nfooterTextVerticalAlign=T\r\nfooterCellVerticalAlign=M\r\nfooterPositionFromBottom=-5\r\nfooterPositionFromBottom=-15\r\nfooterPositionFromLeft=0\r\nspacesBeforeFooter=6\r\n'),
(165, 'Page', 'Path to header logo image file for pdf pages. E.g. misc/input/allmice80.png. This config entry is relevant if display mode is HtmlCss. If display mode is Tcpdf, then header logo file path should be found from config entry tcpdfVariousSettings.', 'logoPath', 'viewPdfEvent', 'misc/input/allmice80.png'),
(166, 'Page', 'Header styles for pdf pages, if headerFooterDisplayMode value is HtmlCss.', 'headerStyles', 'viewPdfEvent', '<style>\r\ntd {\r\n	align: center;\r\n}\r\n.image-cell {\r\n	background-color: #FFFFFF;\r\n	width: 40px;\r\n}\r\n.text-cell {\r\n	width: auto;\r\n	text-align: center;\r\n	background-color: #FFFFFF;\r\n	line-height: 40px;\r\n}\r\n\r\ntable.header-table {\r\n    border-bottom: 1px solid #49758a;\r\n    border-spacing: 4px;\r\n}\r\n\r\n</style>\r\n'),
(167, 'Page', 'Header HTML code for pdf pages, if headerFooterDisplayMode value is HtmlCss.', 'headerHtml', 'viewPdfEvent', '<table class=\"header-table\">\r\n<tr>\r\n[logoCode]\r\n<td class=\"text-cell\">\r\n[title]\r\n</td>\r\n</tr>\r\n</table>'),
(168, 'Page', 'HTML as content of place holder [logoCode] in headerHtml configuration entry for displaying logo image on pdf pages. If you wish not to display any logo image with corresponding HTML code, then leave this configuration value empty.', 'logoCode', 'viewPdfEvent', '&lt;td class=&quot;image-cell&quot;&gt;\r\n&lt;img src=&quot;[logoPath]&quot; height=&quot;40&quot; width=&quot;40&quot; /&gt;\r\n&lt;/td&gt;'),
(169, 'Page', 'Footer styles for pdf pages, if headerFooterDisplayMode value is HtmlCss.', 'footerStyles', 'viewPdfEvent', '<style>\r\ntd {\r\n	align: center;\r\n}\r\n.image-cell {\r\n	width: 40px;\r\n	background-color: #FFFFFF;\r\n}\r\n.text-cell {\r\n	width: auto;\r\n	text-align: center;\r\n	line-height: 40px;\r\n	background-color: #FFFFFF;\r\n}\r\n\r\ntable.footer-table {\r\n}\r\n\r\n</style>\r\n'),
(170, 'Page', 'Footer HTML code for pdf pages, if headerFooterDisplayMode value is HtmlCss.', 'footerHtml', 'viewPdfEvent', '<table class=\"footer-table\">\r\n<tr>\r\n<td style=\"width:9%;\">\r\n</td>\r\n<td class=\"text-cell\">\r\n[footerText] [currentPage]/[allPages]\r\n</td>\r\n<td style=\"width:9%;\">\r\n</td>\r\n</tr>\r\n</table>\r\n'),
(171, 'Page', 'Determines the way, how header and footer are displayed. Possible values are HtmlCss or Tcpdf or off (HtmlCss by any other value). Value off means, that no header nor footer will be used. Tcpdf mode: some of the TCPDF library&#39;s own methods will be used to display header and footer (see also config entry: tcpdfVariousSettings). HtmlCss mode: header and footer will be generated using HTML and CSS (see also: tcpdfVariousSettings, footerHtml, footerStyles, headerHtml, headerStyles, logoCode, logoPath).', 'headerFooterDisplayMode', 'viewPdfEvent', 'HtmlCss'),
(172, 'Page', 'Main styles for pdf pages.', 'mainStyles', 'viewPdfEvent', '<style>\r\n\r\n* {\r\n	margin: 0;\r\n	padding: 0;\r\n	color: #000000;\r\n	line-height: 1.5;\r\n	font: normal 12pt Verdana, sans-serif;\r\n}\r\n\r\na {\r\n	text-decoration:none;\r\n	color: #024;\r\n	padding: 8px;\r\n	line-height: 1.2;\r\n}\r\n\r\nh1 {\r\n	color: navy;\r\n	font-family: times;\r\n	font-size: 24pt;\r\n	text-decoration: underline;\r\n}\r\n\r\ntable, th, td {\r\n	border: 1px solid #49758a;\r\n	border-spacing: 0px;\r\n}\r\n\r\nth {\r\n	margin:0px;\r\n	padding: 2px;\r\n	border-top: 2px solid #29556a;\r\n	border-bottom: 2px solid #29556a;\r\n	border-left: 1px solid #49758a;\r\n	border-right: 1px solid #49758a;\r\n}\r\n\r\ntd {\r\n	margin:2px;\r\n	padding: 2px;\r\n}\r\n\r\ntable.no-border, td.no-border {\r\n	border: 0px solid white;\r\n}\r\n\r\ntd.number {\r\n	text-align: right;\r\n}\r\n\r\ntd.header {\r\n	margin: 2px;\r\n	padding: 2px;\r\n}\r\n\r\n.lowercase {\r\n	text-transform: lowercase;\r\n}\r\n\r\n.uppercase {\r\n	text-transform: uppercase;\r\n}\r\n\r\n.capitalize {\r\n	text-transform: capitalize;\r\n}\r\n\r\n</style>\r\n'),
(173, 'Page', 'Number of white space characters before footer. The third party TCPDF library, which creates PDF pages for Allmice CMS, has a problem that footer text can not be centered correctly. Adding space characters before footer text helps to resolve this problem.', 'spaceBeforeFooter', 'viewPdfEvent', '8');

-- --------------------------------------------------------

--
-- Table structure for table `core_language`
--

CREATE TABLE `core_language` (
  `id` int(11) NOT NULL,
  `language_code` varchar(15) NOT NULL DEFAULT 'en' COMMENT 'Two character code (ISO 639-1) or some other code',
  `type` tinyint(3) NOT NULL DEFAULT '22' COMMENT '11: global block; 21: local form; 22: local other',
  `module_name` varchar(30) NOT NULL DEFAULT '',
  `specific_name` varchar(30) NOT NULL DEFAULT '' COMMENT 'Event name, block name, etc.',
  `uri` varchar(60) NOT NULL DEFAULT '' COMMENT 'Another more specific identifier of the language phrase. Uri is meaning here shortly unique resource identifier. In current context and system uri is not referring to some strict worldwide standard.',
  `text` varchar(510) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_language`
--

INSERT INTO `core_language` (`id`, `language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
(2, 'en', 11, 'GlobalCore', 'siteName', 'siteName', 'Welcome!'),
(3, 'en', 21, 'AppUser', 'indexEvent', 'label/username', 'Username: '),
(4, 'en', 21, 'AppUser', 'indexEvent', 'label/password', 'Password: '),
(5, 'en', 21, 'AppUser', 'indexEvent', 'value/login', 'Log in'),
(6, 'en', 21, 'AppUser', 'indexEvent', 'value/logout', 'Log out'),
(7, 'en', 22, 'AppUser', 'indexEvent', 'label', 'User:'),
(8, 'en', 21, 'AppUser', 'loginEvent', 'label/username', 'Username:'),
(9, 'en', 21, 'AppUser', 'loginEvent', 'label/password', 'Password:'),
(10, 'en', 21, 'AppUser', 'loginEvent', 'value/login', 'Log in'),
(11, 'en', 21, 'AppUser', 'loginEvent', 'value/logout', 'Log out'),
(12, 'en', 22, 'AppUser', 'loginEvent', 'label', 'User:'),
(13, 'en', 22, 'AppUser', 'logoutEvent', 'textLogout', 'User was logged out.'),
(14, 'en', 22, 'App', 'indexEvent', 'title', 'Links for Managing Modules'),
(15, 'en', 22, 'App', 'indexEvent', 'linkApp', 'App module functionality'),
(16, 'en', 22, 'App', 'indexEvent', 'linkAccess', 'Manage Access'),
(17, 'en', 22, 'App', 'indexEvent', 'linkIns', 'Install Modules'),
(18, 'en', 22, 'App', 'indexEvent', 'linkUnins', 'Uninstall Modules'),
(19, 'en', 21, 'App', 'installModulesEvent', 'value/save', 'Install checked modules'),
(20, 'en', 22, 'App', 'installModulesEvent', 'tb1ModTitle', 'Module title'),
(21, 'en', 22, 'App', 'installModulesEvent', 'tb1ModDesc', 'Module description'),
(22, 'en', 22, 'App', 'installModulesEvent', 'tb1ModClassName', 'Module Class name'),
(23, 'en', 22, 'App', 'installModulesEvent', 'tb1ModVersion', 'Module version'),
(24, 'en', 22, 'App', 'installModulesEvent', 'tb1ModTime', 'Module release time'),
(25, 'en', 22, 'App', 'installModulesEvent', 'title', 'Install Modules'),
(26, 'en', 22, 'App', 'installModulesEvent', 'link1', 'Administrator menu'),
(27, 'en', 22, 'App', 'installModulesEvent', 'text1Access', 'After installing modules you need to assign access rights (permissions) for roles to access these modules.'),
(28, 'en', 22, 'App', 'installModulesEvent', 'text2Access', 'Go to following page to assign permissions:'),
(29, 'en', 22, 'App', 'installModulesEvent', 'link2', 'Manage access'),
(30, 'en', 22, 'App', 'installModulesEvent', 'tb1Title', 'Uninstalled modules'),
(31, 'en', 22, 'App', 'installModulesEvent', 'tb2Title', 'Installed modules'),
(32, 'en', 22, 'App', 'installModulesEvent', 'text3NoUninsMod', 'There are no uninstalled modules.'),
(33, 'en', 22, 'App', 'installModulesEvent', 'text4NoInsMod', 'There are no installed modules.'),
(34, 'en', 21, 'App', 'uninstallModulesEvent', 'value/login', 'Install checked modules'),
(35, 'en', 21, 'App', 'uninstallModulesEvent', 'value/save', 'Uninstall checked modules'),
(36, 'en', 22, 'App', 'uninstallModulesEvent', 'title', 'Uninstall Modules'),
(37, 'en', 22, 'App', 'uninstallModulesEvent', 'link1', 'Administrator menu'),
(38, 'en', 22, 'App', 'uninstallModulesEvent', 'tb1Title', 'Uninstalled modules'),
(39, 'en', 22, 'App', 'uninstallModulesEvent', 'tb2Title', 'Installed modules'),
(40, 'en', 22, 'App', 'uninstallModulesEvent', 'text3NoUninsMod', 'There are no uninstalled modules.'),
(41, 'en', 22, 'App', 'uninstallModulesEvent', 'text4NoInsMod', 'There are no installed modules.'),
(42, 'en', 22, 'App', 'uninstallModulesEvent', 'tb1ModTitle', 'Module title'),
(43, 'en', 22, 'App', 'uninstallModulesEvent', 'tb1ModDesc', 'Module description'),
(44, 'en', 22, 'App', 'uninstallModulesEvent', 'tb1ModClassName', 'Module class name'),
(45, 'en', 22, 'App', 'uninstallModulesEvent', 'tb1ModVersion', 'Module version'),
(46, 'en', 22, 'App', 'uninstallModulesEvent', 'tb1ModTime', 'Module release time'),
(47, 'en', 21, 'App', 'manageAccessEvent', 'label/modId', 'Select module:'),
(48, 'en', 21, 'App', 'manageAccessEvent', 'label/roleId', 'Select role:'),
(49, 'en', 21, 'App', 'manageAccessEvent', 'value/save', 'Save changes'),
(50, 'en', 22, 'App', 'manageAccessEvent', 'title', 'Manage Access Rights'),
(51, 'en', 22, 'App', 'manageAccessEvent', 'link1', 'Administrator menu'),
(52, 'en', 22, 'App', 'manageAccessEvent', 'text1selMod', 'Select module:'),
(53, 'en', 22, 'App', 'manageAccessEvent', 'text2selMod', 'Select the module, for which you wish to grant displaying access right.'),
(54, 'en', 22, 'App', 'manageAccessEvent', 'text3selRole', 'Select role:'),
(55, 'en', 22, 'App', 'manageAccessEvent', 'text4selRole', 'Choose the role, for which you wish to assing content displaying access right.'),
(56, 'en', 22, 'App', 'manageAccessEvent', 'text5selCheck', 'Check the boxes below for the contents, which you wish to display for the corresponding user role.'),
(57, 'en', 22, 'App', 'manageAccessEvent', 'tb1ModName', 'Module name'),
(58, 'en', 22, 'App', 'manageAccessEvent', 'tb1ChangeAcc', 'Change access:'),
(59, 'en', 22, 'App', 'manageAccessEvent', 'tb1YesNo', '[v]-yes/[ ]-no'),
(60, 'en', 22, 'App', 'manageAccessEvent', 'tb1Event', 'Event name'),
(61, 'en', 22, 'App', 'manageAccessEvent', 'tb1ValidAcc', 'Valid access'),
(62, 'en', 11, 'AppUser', 'appUserArea', 'link/login', 'Log in'),
(63, 'en', 11, 'AppUser', 'appUserArea', 'link/logout', 'Log out'),
(64, 'en', 11, 'AppUser', 'appUserArea', 'label', 'User:'),
(65, 'en', 22, 'App', 'installModulesEvent', 'tb1ModDeveloper', 'Module developer, copyright, licence, etc.'),
(66, 'en', 22, 'App', 'uninstallModulesEvent', 'tb1ModDeveloper', 'Module developer, copyright, licence, etc.'),
(67, 'en', 22, 'SystemManager', 'indexEvent', 'title', 'Links for Managing Modules'),
(68, 'en', 22, 'SystemManager', 'indexEvent', 'linkApp', 'App module functionality'),
(69, 'en', 22, 'SystemManager', 'indexEvent', 'linkAccess', 'Manage Access'),
(70, 'en', 22, 'SystemManager', 'indexEvent', 'linkIns', 'Install Modules'),
(71, 'en', 22, 'SystemManager', 'indexEvent', 'linkUnins', 'Uninstall Modules'),
(72, 'en', 21, 'SystemManager', 'installModulesEvent', 'value/save', 'Install checked modules'),
(73, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb1ModTitle', 'Module title'),
(74, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb1ModDesc', 'Module Description'),
(75, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb1ModClassName', 'Module Name'),
(76, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb1ModVersion', 'Module Version'),
(77, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb1ModTime', 'Module Release Time'),
(78, 'en', 22, 'SystemManager', 'installModulesEvent', 'title', 'Install Modules'),
(79, 'en', 22, 'SystemManager', 'installModulesEvent', 'link1', 'Administrator menu'),
(80, 'en', 22, 'SystemManager', 'installModulesEvent', 'text1Access', 'After installing modules you need to assign access rights (permissions) for roles to access these modules.'),
(81, 'en', 22, 'SystemManager', 'installModulesEvent', 'text2Access', 'Go to following page to assign permissions:'),
(82, 'en', 22, 'SystemManager', 'installModulesEvent', 'link2', 'Manage access'),
(83, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb1Title', 'Uninstalled modules'),
(84, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb2Title', 'Installed modules'),
(85, 'en', 22, 'SystemManager', 'installModulesEvent', 'text3NoUninsMod', 'There are no uninstalled modules.'),
(86, 'en', 22, 'SystemManager', 'installModulesEvent', 'text4NoInsMod', 'There are no installed modules.'),
(87, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb1ModDeveloper', 'Module developer, copyright, license, etc.'),
(88, 'en', 22, 'SystemManager', 'installModulesEvent', 'tb1ModRequired', 'Relations to other modules'),
(89, 'en', 21, 'SystemManager', 'uninstallModulesEvent', 'value/login', 'Install checked modules'),
(90, 'en', 21, 'SystemManager', 'uninstallModulesEvent', 'value/save', 'Uninstall checked modules'),
(91, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'title', 'Uninstall Modules'),
(92, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'link1', 'Administrator menu'),
(93, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb1Title', 'Uninstalled Modules'),
(94, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb2Title', 'Installed Modules'),
(95, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'text3NoUninsMod', 'There are no uninstalled modules.'),
(96, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'text4NoInsMod', 'There are no installed modules.'),
(97, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb1ModTitle', 'Module Title'),
(98, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb1ModDesc', 'Module description'),
(99, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb1ModClassName', 'Module name'),
(100, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb1ModVersion', 'Module version'),
(101, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb1ModTime', 'Module release time'),
(102, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb1ModDeveloper', 'Module developer, copyright, license, etc.'),
(103, 'en', 22, 'SystemManager', 'uninstallModulesEvent', 'tb1ModRequired', 'Relations to other modules'),
(104, 'en', 21, 'SystemManager', 'manageAccessEvent', 'label/modId', 'Select module:'),
(105, 'en', 21, 'SystemManager', 'manageAccessEvent', 'label/roleId', 'Select role:'),
(106, 'en', 21, 'SystemManager', 'manageAccessEvent', 'value/save', 'Save changes'),
(107, 'en', 22, 'SystemManager', 'manageAccessEvent', 'title', 'Manage Access Rights'),
(108, 'en', 22, 'SystemManager', 'manageAccessEvent', 'link1', 'Administrator menu'),
(109, 'en', 22, 'SystemManager', 'manageAccessEvent', 'text1selMod', 'Select module:'),
(110, 'en', 22, 'SystemManager', 'manageAccessEvent', 'text2selMod', 'Select, for which module content you wish to grant displaying access right.'),
(111, 'en', 22, 'SystemManager', 'manageAccessEvent', 'text3selRole', 'Select role:'),
(112, 'en', 22, 'SystemManager', 'manageAccessEvent', 'text4selRole', 'Choose the role, which you wish to assign content displaying access right for.'),
(113, 'en', 22, 'SystemManager', 'manageAccessEvent', 'text5selCheck', 'Check the boxes below for the contents, which you wish to display for the corresponding user role.'),
(114, 'en', 22, 'SystemManager', 'manageAccessEvent', 'tb1ModName', 'Module name'),
(115, 'en', 22, 'SystemManager', 'manageAccessEvent', 'tb1ChangeAcc', 'Change access:'),
(116, 'en', 22, 'SystemManager', 'manageAccessEvent', 'tb1YesNo', '[v]-yes/[ ]-no'),
(117, 'en', 22, 'SystemManager', 'manageAccessEvent', 'tb1Event', 'Event name'),
(118, 'en', 22, 'SystemManager', 'manageAccessEvent', 'tb1ValidAcc', 'Valid access'),
(119, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'title', 'Uninstall Modules Preserving Data'),
(120, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'link1', 'System Manager module main page'),
(121, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'tb1Title', 'Uninstalled modules'),
(122, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'tb2Title', 'Installed modules'),
(123, 'en', 21, 'SystemManager', 'uninstallModuleStructureEvent', 'value/save', 'Update checked modules'),
(124, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'text3NoUninsMod', 'There are no uninstalled modules.'),
(125, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'text4NoInsMod', 'There are no installed modules.'),
(126, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'tb1ModTitle', 'Module title'),
(127, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'tb1ModDesc', 'Module description'),
(128, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'tb1ModClassName', 'Module name'),
(129, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'tb1ModVersion', 'Module version'),
(130, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'tb1ModTime', 'Module release time'),
(131, 'en', 22, 'SystemManager', 'uninstallModuleStructureEvent', 'tb1ModDeveloper', 'Module developer'),
(132, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'title', 'Install Modules Using Existing Data'),
(133, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'link1', 'System Manager module main page'),
(134, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'text1Access', 'After installing modules you need to assign access rights (permissions) for roles to access these modules.'),
(135, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'text2Access', 'Go to following page to assign permissions:'),
(136, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'link2', 'Manage access'),
(137, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'tb1Title', 'Uninstalled modules'),
(138, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'tb2Title', 'Installed modules'),
(139, 'en', 21, 'SystemManager', 'installModuleStructureEvent', 'value/save', 'Install checked modules'),
(140, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'text3NoUninsMod', 'There are no uninstalled modules.'),
(141, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'text4NoInsMod', 'There are no installed modules.'),
(142, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'tb1ModTitle', 'Module title'),
(143, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'tb1ModDesc', 'Module description'),
(144, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'tb1ModClassName', 'Module name'),
(145, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'tb1ModVersion', 'Module version'),
(146, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'tb1ModTime', 'Module release time'),
(147, 'en', 22, 'SystemManager', 'installModuleStructureEvent', 'tb1ModDeveloper', 'Module developer'),
(148, 'en', 11, 'GlobalObserver', 'consentBlock', 'consentMessage1', 'This website uses cookies to ensure you get the best experience on our website. By using our website, you acknowledge that you understand and agree with our Privacy and Cookies Policy and other terms.'),
(149, 'en', 11, 'GlobalObserver', 'consentBlock', 'consentMessage2', ''),
(150, 'en', 11, 'GlobalObserver', 'consentBlock', 'consentButton1', 'Got it'),
(151, 'en', 11, 'GlobalObserver', 'consentBlock', 'consentLink1', 'More info'),
(152, 'en', 21, 'Message', 'addTemplateEvent', 'guide/code', 'A unique code (identifier) for computer as array key to use this template in modules. Suggested as camelCase string without spaces. E.g. \"sendAccValCode\".'),
(153, 'en', 21, 'Message', 'addTemplateEvent', 'guide/contentHtml', 'Template for the HTML text content part of a message.'),
(154, 'en', 21, 'Message', 'addTemplateEvent', 'guide/contentPlain', 'Template for the plain text content part of a message.'),
(155, 'en', 21, 'Message', 'addTemplateEvent', 'guide/language', 'Two character code (ISO 639-1) or some other language code.'),
(156, 'en', 21, 'Message', 'addTemplateEvent', 'guide/module', 'Name of the module, which is using this template to compose messages.'),
(157, 'en', 21, 'Message', 'addTemplateEvent', 'guide/subject', 'Template for the subject part of a message.'),
(158, 'en', 21, 'Message', 'addTemplateEvent', 'guide/type', 'Some type string, which helps to filter out specific templates. This type can be used to list specific templates.'),
(159, 'en', 21, 'Message', 'addTemplateEvent', 'label/code', 'Code'),
(160, 'en', 21, 'Message', 'addTemplateEvent', 'label/contentHtml', 'HTML content template'),
(161, 'en', 21, 'Message', 'addTemplateEvent', 'label/contentPlain', 'Plain content template'),
(162, 'en', 21, 'Message', 'addTemplateEvent', 'label/language', 'Language'),
(163, 'en', 21, 'Message', 'addTemplateEvent', 'label/module', 'Module'),
(164, 'en', 21, 'Message', 'addTemplateEvent', 'label/subject', 'Message subject template'),
(165, 'en', 21, 'Message', 'addTemplateEvent', 'label/type', 'Type'),
(166, 'en', 21, 'Message', 'addTemplateEvent', 'value/save', 'Save'),
(167, 'en', 22, 'Message', 'addTemplateEvent', 'title', 'Add a New Message Template'),
(168, 'en', 22, 'Message', 'deleteTemplateEvent', 'afterField1', 'code'),
(169, 'en', 22, 'Message', 'deleteTemplateEvent', 'afterField2', 'module name'),
(170, 'en', 22, 'Message', 'deleteTemplateEvent', 'afterField3', 'type'),
(171, 'en', 22, 'Message', 'deleteTemplateEvent', 'afterField4', 'subject'),
(172, 'en', 22, 'Message', 'deleteTemplateEvent', 'afterMessage', 'The message template with following details was deleted:'),
(173, 'en', 22, 'Message', 'deleteTemplateEvent', 'beforeField1', 'code is'),
(174, 'en', 22, 'Message', 'deleteTemplateEvent', 'beforeField2', 'module name is'),
(175, 'en', 22, 'Message', 'deleteTemplateEvent', 'beforeField3', 'type is'),
(176, 'en', 22, 'Message', 'deleteTemplateEvent', 'beforeField4', 'subject is'),
(177, 'en', 22, 'Message', 'deleteTemplateEvent', 'beforeMessage', 'Are you sure, that you wish to delete the template with following details?'),
(178, 'en', 22, 'Message', 'deleteTemplateEvent', 'link1', 'Show list of message templates!'),
(180, 'en', 22, 'Message', 'deleteTemplateEvent', 'submitYes', 'Delete this template!'),
(181, 'en', 22, 'Message', 'deleteTemplateEvent', 'title', 'Delete a Message Template'),
(182, 'en', 21, 'Message', 'editTemplateEvent', 'guide/code', 'A unique code (identifier) for computer as array key to use this template in modules. Suggested as camelCase string without spaces. E.g. \"sendAccValCode\".'),
(183, 'en', 21, 'Message', 'editTemplateEvent', 'guide/contentHtml', 'Template for the HTML text content part of a message.'),
(184, 'en', 21, 'Message', 'editTemplateEvent', 'guide/contentPlain', 'Template for the plain text content part of a message.'),
(185, 'en', 21, 'Message', 'editTemplateEvent', 'guide/language', 'Two character code (ISO 639-1) or some other language code.'),
(186, 'en', 21, 'Message', 'editTemplateEvent', 'guide/module', 'Name of the module, which is using this template to compose messages.'),
(187, 'en', 21, 'Message', 'editTemplateEvent', 'guide/subject', 'Template for the subject part of a message.'),
(188, 'en', 21, 'Message', 'editTemplateEvent', 'guide/type', 'Some type string, which helps to filter out specific templates. This type can be used to list specific templates.'),
(189, 'en', 21, 'Message', 'editTemplateEvent', 'label/code', 'Code'),
(190, 'en', 21, 'Message', 'editTemplateEvent', 'label/contentHtml', 'HTML content template'),
(191, 'en', 21, 'Message', 'editTemplateEvent', 'label/contentPlain', 'Plain content template'),
(192, 'en', 21, 'Message', 'editTemplateEvent', 'label/language', 'Language'),
(193, 'en', 21, 'Message', 'editTemplateEvent', 'label/module', 'Module'),
(194, 'en', 21, 'Message', 'editTemplateEvent', 'label/subject', 'Message subject template'),
(195, 'en', 21, 'Message', 'editTemplateEvent', 'label/type', 'Type'),
(196, 'en', 21, 'Message', 'editTemplateEvent', 'value/save', 'Save'),
(197, 'en', 22, 'Message', 'editTemplateEvent', 'title', 'Edit an Existing Message Template'),
(198, 'en', 22, 'Message', 'listTemplatesEvent', 'link1', 'Add'),
(199, 'en', 22, 'Message', 'listTemplatesEvent', 'link2', 'Edit'),
(200, 'en', 22, 'Message', 'listTemplatesEvent', 'link3', 'Delete'),
(201, 'en', 22, 'Message', 'listTemplatesEvent', 'message1', 'There are no templates.'),
(202, 'en', 22, 'Message', 'listTemplatesEvent', 'tb1Code', 'Code'),
(203, 'en', 22, 'Message', 'listTemplatesEvent', 'tb1Module', 'Module'),
(204, 'en', 22, 'Message', 'listTemplatesEvent', 'tb1Subject', 'Subject'),
(205, 'en', 22, 'Message', 'listTemplatesEvent', 'tb1Type', 'Type'),
(206, 'en', 22, 'Message', 'listTemplatesEvent', 'title', 'List of Message Templates'),
(207, 'en', 22, 'Message', 'listMessagesEvent', 'link1', 'Write a new message'),
(208, 'en', 22, 'Message', 'listMessagesEvent', 'link2', 'List user blockings'),
(209, 'en', 22, 'Message', 'listMessagesEvent', 'message1', 'There are no received messages.'),
(210, 'en', 22, 'Message', 'listMessagesEvent', 'message2', 'There are no sent or unsent saved messages.'),
(211, 'en', 22, 'Message', 'listMessagesEvent', 'tb1Title', 'Received messages:'),
(212, 'en', 22, 'Message', 'listMessagesEvent', 'tb1ColSubject', 'Subject'),
(213, 'en', 22, 'Message', 'listMessagesEvent', 'tb1ColSender', 'Sender'),
(214, 'en', 22, 'Message', 'listMessagesEvent', 'tb1ColTime', 'Time'),
(215, 'en', 22, 'Message', 'listMessagesEvent', 'tb1ColStatus', 'Status'),
(216, 'en', 22, 'Message', 'listMessagesEvent', 'tb1LinkRead', 'Read'),
(217, 'en', 22, 'Message', 'listMessagesEvent', 'tb1LinkReply', 'Reply'),
(218, 'en', 22, 'Message', 'listMessagesEvent', 'tb1LinkDelete', 'Delete'),
(219, 'en', 22, 'Message', 'listMessagesEvent', 'tb2Title', 'Sent or unsent saved messages:'),
(220, 'en', 22, 'Message', 'listMessagesEvent', 'tb2ColSubject', 'Subject'),
(221, 'en', 22, 'Message', 'listMessagesEvent', 'tb2ColRecipient', 'Sender'),
(222, 'en', 22, 'Message', 'listMessagesEvent', 'tb2ColTime', 'Time'),
(223, 'en', 22, 'Message', 'listMessagesEvent', 'tb2ColStatus', 'Status'),
(224, 'en', 22, 'Message', 'listMessagesEvent', 'tb2LinkRead', 'Read'),
(225, 'en', 22, 'Message', 'listMessagesEvent', 'tb2LinkEdit', 'Edit'),
(226, 'en', 22, 'Message', 'listMessagesEvent', 'tb2LinkDelete', 'Delete'),
(227, 'en', 22, 'Message', 'listMessagesEvent', 'title', 'List of My Messages'),
(228, 'en', 22, 'Message', 'listMessagesEvent', 'statusOption1', 'Unsent'),
(229, 'en', 22, 'Message', 'listMessagesEvent', 'statusOption2', 'Sent'),
(230, 'en', 22, 'Message', 'listMessagesEvent', 'statusOption3', 'Unread'),
(231, 'en', 22, 'Message', 'listMessagesEvent', 'senderSystem', 'Automated system message'),
(232, 'en', 21, 'Message', 'writeMessageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(233, 'en', 21, 'Message', 'writeMessageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(234, 'en', 21, 'Message', 'writeMessageEvent', 'guide/receiverName', ''),
(235, 'en', 21, 'Message', 'writeMessageEvent', 'guide/subject', ''),
(236, 'en', 21, 'Message', 'writeMessageEvent', 'guide/content', ''),
(237, 'en', 21, 'Message', 'writeMessageEvent', 'label/receiverName', 'Receiver Name:'),
(238, 'en', 21, 'Message', 'writeMessageEvent', 'label/subject', 'Subject:'),
(239, 'en', 21, 'Message', 'writeMessageEvent', 'label/content', 'Content:'),
(240, 'en', 21, 'Message', 'writeMessageEvent', 'value/save', 'Save'),
(241, 'en', 21, 'Message', 'writeMessageEvent', 'value/send', 'Send'),
(242, 'en', 22, 'Message', 'writeMessageEvent', 'message1', 'Message was saved.'),
(243, 'en', 22, 'Message', 'writeMessageEvent', 'message2', 'Authentication email address (username) and/or password are not configured.'),
(244, 'en', 22, 'Message', 'writeMessageEvent', 'message3', 'Message was sent.'),
(245, 'en', 22, 'Message', 'writeMessageEvent', 'message4', 'You can not send message to such user - such user does not exist or has blocking for receiving messages.'),
(246, 'en', 22, 'Message', 'writeMessageEvent', 'replyStart', '--------------------\nAt [messageTime], [senderName] wrote:\n'),
(247, 'en', 22, 'Message', 'writeMessageEvent', 'link1', 'Show list of messages!'),
(248, 'en', 22, 'Message', 'writeMessageEvent', 'title', 'Write a Message'),
(249, 'en', 21, 'Message', 'editMessageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(250, 'en', 21, 'Message', 'editMessageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(251, 'en', 21, 'Message', 'editMessageEvent', 'guide/receiverName', ''),
(252, 'en', 21, 'Message', 'editMessageEvent', 'guide/subject', ''),
(253, 'en', 21, 'Message', 'editMessageEvent', 'guide/content', ''),
(254, 'en', 21, 'Message', 'editMessageEvent', 'label/receiverName', 'Receiver Name:'),
(255, 'en', 21, 'Message', 'editMessageEvent', 'label/subject', 'Subject:'),
(256, 'en', 21, 'Message', 'editMessageEvent', 'label/content', 'Content:'),
(257, 'en', 21, 'Message', 'editMessageEvent', 'value/save', 'Save'),
(258, 'en', 21, 'Message', 'editMessageEvent', 'value/send', 'Send'),
(259, 'en', 22, 'Message', 'editMessageEvent', 'message1', 'Message was saved.'),
(260, 'en', 22, 'Message', 'editMessageEvent', 'message2', 'Authentication email address (username) and/or password are not configured.'),
(261, 'en', 22, 'Message', 'editMessageEvent', 'message3', 'Message was sent.'),
(262, 'en', 22, 'Message', 'editMessageEvent', 'message4', 'You can not send message to such user - such user does not exist or has blocking for receiving messages.'),
(263, 'en', 22, 'Message', 'editMessageEvent', 'message5', 'Such message does not exist or you can not access it.'),
(264, 'en', 22, 'Message', 'editMessageEvent', 'link1', 'Show list of messages!'),
(265, 'en', 22, 'Message', 'editMessageEvent', 'title', 'Edit Own Message'),
(266, 'en', 22, 'Message', 'deleteMessageEvent', 'afterMessage', 'The message with following details was deleted:'),
(267, 'en', 22, 'Message', 'deleteMessageEvent', 'beforeField1', 'sender is:'),
(268, 'en', 22, 'Message', 'deleteMessageEvent', 'beforeField2', 'recipient is:'),
(269, 'en', 22, 'Message', 'deleteMessageEvent', 'beforeField3', 'time is:'),
(270, 'en', 22, 'Message', 'deleteMessageEvent', 'beforeField4', 'subject is:'),
(271, 'en', 22, 'Message', 'deleteMessageEvent', 'beforeMessage', 'Are you sure, that you wish to delete the message with following details?'),
(272, 'en', 22, 'Message', 'deleteMessageEvent', 'message1', 'Such message does not exist or you can not access it.'),
(273, 'en', 22, 'Message', 'deleteMessageEvent', 'message2', 'Message id is not correct.'),
(274, 'en', 22, 'Message', 'deleteMessageEvent', 'submitYes', 'Delete this message!'),
(275, 'en', 22, 'Message', 'deleteMessageEvent', 'title', 'Delete Own Message'),
(276, 'en', 22, 'Message', 'deleteMessageEvent', 'afterField1', 'from:'),
(277, 'en', 22, 'Message', 'deleteMessageEvent', 'afterField2', 'to:'),
(278, 'en', 22, 'Message', 'deleteMessageEvent', 'afterField3', 'time:'),
(279, 'en', 22, 'Message', 'deleteMessageEvent', 'afterField4', 'subject:'),
(280, 'en', 22, 'Message', 'deleteMessageEvent', 'link1', 'Show list of messages!'),
(281, 'en', 22, 'Message', 'viewMessageEvent', 'link1', 'Show list of messages!'),
(282, 'en', 22, 'Message', 'viewMessageEvent', 'message1', 'Such message does not exist or you can not access it.'),
(283, 'en', 22, 'Message', 'viewMessageEvent', 'message2', 'Automated system message.'),
(284, 'en', 22, 'Message', 'viewMessageEvent', 'message3', 'Message id is not correct.'),
(285, 'en', 22, 'Message', 'viewMessageEvent', 'label1', 'From:'),
(286, 'en', 22, 'Message', 'viewMessageEvent', 'label2', 'To:'),
(287, 'en', 22, 'Message', 'viewMessageEvent', 'label3', 'Time:'),
(288, 'en', 22, 'Message', 'viewMessageEvent', 'label4', 'Subject:'),
(289, 'en', 22, 'Message', 'viewMessageEvent', 'label5', 'Content:'),
(290, 'en', 22, 'Message', 'viewMessageEvent', 'title', 'View Own Message'),
(291, 'en', 21, 'Message', 'addUserBlockingEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(292, 'en', 21, 'Message', 'addUserBlockingEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(293, 'en', 21, 'Message', 'addUserBlockingEvent', 'guide/username', ''),
(294, 'en', 21, 'Message', 'addUserBlockingEvent', 'label/username', 'Username:'),
(295, 'en', 21, 'Message', 'addUserBlockingEvent', 'value/save', 'Save'),
(296, 'en', 22, 'Message', 'addUserBlockingEvent', 'title', 'Add User Blocking'),
(297, 'en', 22, 'Message', 'addUserBlockingEvent', 'link1', 'Show list of blocked users!'),
(298, 'en', 22, 'Message', 'addUserBlockingEvent', 'message1', 'User [username] was added to the blocking list.'),
(299, 'en', 22, 'Message', 'addUserBlockingEvent', 'message2', 'Such user does not exist, is administrator or is already blocked.'),
(300, 'en', 22, 'Message', 'addUserBlockingEvent', 'message3', 'There are too many user blockings. To add new user blockings remove some old blockings. Be aware, that the limit amount of user blockings depends on the lengths of usernames.'),
(301, 'en', 22, 'Message', 'listUserBlockingsEvent', 'link1', 'Block a user'),
(302, 'en', 22, 'Message', 'listUserBlockingsEvent', 'link2', 'Show list of messages'),
(303, 'en', 22, 'Message', 'listUserBlockingsEvent', 'tb1Title', 'Blocked users are:'),
(304, 'en', 22, 'Message', 'listUserBlockingsEvent', 'tb1ColName', 'Username'),
(305, 'en', 22, 'Message', 'listUserBlockingsEvent', 'tb1LinkRemove', 'Remove blocking'),
(306, 'en', 22, 'Message', 'listUserBlockingsEvent', 'message1', 'There are no blocked users.'),
(307, 'en', 22, 'Message', 'listUserBlockingsEvent', 'title', 'List of Blocked Users'),
(308, 'en', 22, 'Message', 'removeUserBlockingEvent', 'title', 'Remove a Blocked User'),
(309, 'en', 22, 'Message', 'removeUserBlockingEvent', 'link1', 'Show list of blocked users!'),
(310, 'en', 22, 'Message', 'removeUserBlockingEvent', 'message1', 'User [username] was removed from the blocking list.'),
(311, 'en', 22, 'Message', 'removeUserBlockingEvent', 'message2', 'Such user does not exist, is administrator or is not in blocking list.'),
(312, 'en', 21, 'Page', 'addPageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(313, 'en', 21, 'Page', 'addPageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(314, 'en', 21, 'Page', 'addPageEvent', 'guide/bodyArea', 'Main content of the page.'),
(315, 'en', 21, 'Page', 'addPageEvent', 'guide/botTag', 'Html meta tag for robots.'),
(316, 'en', 21, 'Page', 'addPageEvent', 'guide/caching', 'Choose, for which roles this page will be cached. Hold down Ctrl key to check multiple roles.'),
(317, 'en', 21, 'Page', 'addPageEvent', 'guide/descriptionArea', 'Description of the page for html description meta tag. Helps Search Engine Optimizing. If field is empty, then default site wide, default Page module or default view method description will be used.'),
(318, 'en', 21, 'Page', 'addPageEvent', 'guide/label', 'Human readable label for menu item (if this field is empty, then no menu item will be used for this page).'),
(319, 'en', 21, 'Page', 'addPageEvent', 'guide/menuId', 'Choose menu, where this item belongs to (if no menu is chosen, then no menu item will be used for this page).'),
(320, 'en', 21, 'Page', 'addPageEvent', 'guide/parentId', 'Choose parent item in the menu for the current menu item.'),
(321, 'en', 21, 'Page', 'addPageEvent', 'guide/roleAccess', 'Choose, which roles can view this page. Hold down Ctrl key to check multiple roles.'),
(322, 'en', 21, 'Page', 'addPageEvent', 'guide/status', 'Choose, whether this page is published or not. Good to use this option if page is not ready yet or in other occasions.'),
(323, 'en', 21, 'Page', 'addPageEvent', 'guide/title', 'Title of the page (usually used for html title tag and in h1 tag). This field should not be empty.'),
(324, 'en', 21, 'Page', 'addPageEvent', 'guide/weight', 'Weight is an integer number, which determines order of menu items.'),
(325, 'en', 21, 'Page', 'addPageEvent', 'label/alias', 'URL alias'),
(326, 'en', 21, 'Page', 'addPageEvent', 'label/bodyArea', 'Body'),
(327, 'en', 21, 'Page', 'addPageEvent', 'label/botTag', 'Robot meta tag'),
(328, 'en', 21, 'Page', 'addPageEvent', 'label/caching', 'Caching for roles'),
(329, 'en', 21, 'Page', 'addPageEvent', 'label/descriptionArea', 'Description meta tag'),
(330, 'en', 21, 'Page', 'addPageEvent', 'label/label', 'Menu item label'),
(331, 'en', 21, 'Page', 'addPageEvent', 'label/menuId', 'Menu'),
(332, 'en', 21, 'Page', 'addPageEvent', 'label/parentId', 'Menu item location'),
(333, 'en', 21, 'Page', 'addPageEvent', 'label/roleAccess', 'Access right for roles'),
(334, 'en', 21, 'Page', 'addPageEvent', 'label/status', 'Page status'),
(335, 'en', 21, 'Page', 'addPageEvent', 'label/title', 'Title'),
(336, 'en', 21, 'Page', 'addPageEvent', 'label/weight', 'Weight'),
(337, 'en', 21, 'Page', 'addPageEvent', 'value/submit1', 'Save'),
(338, 'en', 22, 'Page', 'addPageEvent', 'botTagOption1', 'No tag (default - index, follow)'),
(339, 'en', 22, 'Page', 'addPageEvent', 'link1', 'Show list of pages!'),
(340, 'en', 22, 'Page', 'addPageEvent', 'subTitle1', 'Main area'),
(341, 'en', 22, 'Page', 'addPageEvent', 'subTitle2', 'Menu area'),
(342, 'en', 22, 'Page', 'addPageEvent', 'subTitle3', 'Other options'),
(343, 'en', 22, 'Page', 'addPageEvent', 'menuOption0', 'No menu is chosen'),
(344, 'en', 22, 'Page', 'addPageEvent', 'statusOption1', 'Published'),
(345, 'en', 22, 'Page', 'addPageEvent', 'statusOption2', 'Not published'),
(346, 'en', 22, 'Page', 'addPageEvent', 'submitMessage', 'Page was added.'),
(347, 'en', 22, 'Page', 'addPageEvent', 'aliasProblem', 'Alias is not correct and page was not saved. Most common causes for this problem: This alias may already exist for another page or starts with path of an installed module or does not have a leading slash (/) or has many leading slashes.'),
(348, 'en', 22, 'Page', 'addPageEvent', 'title', 'Add a New Page'),
(349, 'en', 21, 'Page', 'addSnippetEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(350, 'en', 21, 'Page', 'addSnippetEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(351, 'en', 21, 'Page', 'addSnippetEvent', 'guide/snippetCode', 'An unique code to identify this snippet from all the other snippets of the current page.'),
(352, 'en', 21, 'Page', 'addSnippetEvent', 'guide/snippetContent', 'Content of the snippet.'),
(353, 'en', 21, 'Page', 'addSnippetEvent', 'guide/snippetType', 'If type is plain text, then the content form field should include text, which will be displayed in snippet. If type is PHP code, then it should include location to the PHP code class and then refer to method, which will return the snippet content in this class, separated by ";". For example, something like: custom/modules/[ModuleName]/Model/[ClassFileName.php];[methodName].'),
(354, 'en', 21, 'Page', 'addSnippetEvent', 'label/snippetCode', 'Unique snippet code:'),
(355, 'en', 21, 'Page', 'addSnippetEvent', 'label/snippetContent', 'Snippet content:'),
(356, 'en', 21, 'Page', 'addSnippetEvent', 'label/snippetType', 'Snippet type:'),
(357, 'en', 21, 'Page', 'addSnippetEvent', 'value/save', 'Save'),
(358, 'en', 22, 'Page', 'addSnippetEvent', 'label1', 'Page title:'),
(359, 'en', 22, 'Page', 'addSnippetEvent', 'label2', 'Url alias:'),
(360, 'en', 22, 'Page', 'addSnippetEvent', 'label3', 'Start of page body:'),
(361, 'en', 22, 'Page', 'addSnippetEvent', 'link1', 'Show list of snippets!'),
(362, 'en', 22, 'Page', 'addSnippetEvent', 'message1', 'Page id is not correct.'),
(363, 'en', 22, 'Page', 'addSnippetEvent', 'message2', 'A page with such id does not exist or you can not add snippets to this page.'),
(364, 'en', 22, 'Page', 'addSnippetEvent', 'title', 'Add a New Snippet'),
(365, 'en', 22, 'Page', 'addSnippetEvent', 'typeOption1', 'Plain text'),
(366, 'en', 22, 'Page', 'addSnippetEvent', 'typeOption2', 'PHP code'),
(367, 'en', 22, 'Page', 'deleteAnyPageEvent', 'afterField1', 'title'),
(368, 'en', 22, 'Page', 'deleteAnyPageEvent', 'afterMessage', 'The page with following details was deleted:'),
(369, 'en', 22, 'Page', 'deleteAnyPageEvent', 'beforeField1', 'title is'),
(370, 'en', 22, 'Page', 'deleteAnyPageEvent', 'beforeMessage', 'Are you sure, that you wish to delete the page with following details?'),
(371, 'en', 22, 'Page', 'deleteAnyPageEvent', 'link1', 'Show list of pages!'),
(372, 'en', 22, 'Page', 'deleteAnyPageEvent', 'message1', 'Page id is not correct!'),
(373, 'en', 22, 'Page', 'deleteAnyPageEvent', 'submitYes', 'Delete this page!'),
(374, 'en', 22, 'Page', 'deleteAnyPageEvent', 'title', 'Delete Page'),
(375, 'en', 22, 'Page', 'deletePostEvent', 'afterField1', 'Creator:'),
(376, 'en', 22, 'Page', 'deletePostEvent', 'afterField2', 'Posting time:'),
(377, 'en', 22, 'Page', 'deletePostEvent', 'afterField3', 'Start of content:'),
(378, 'en', 22, 'Page', 'deletePostEvent', 'afterMessage', 'Post with following details was deleted:'),
(379, 'en', 22, 'Page', 'deletePostEvent', 'beforeField1', 'Creator is:'),
(380, 'en', 22, 'Page', 'deletePostEvent', 'beforeField2', 'Posting time is:'),
(381, 'en', 22, 'Page', 'deletePostEvent', 'beforeField3', 'Start of content is:'),
(382, 'en', 22, 'Page', 'deletePostEvent', 'beforeMessage', 'Are you sure, that you wish to delete the post with following details?'),
(383, 'en', 22, 'Page', 'deletePostEvent', 'intro', 'This post is related to page...'),
(384, 'en', 22, 'Page', 'deletePostEvent', 'label1', 'Page title:'),
(385, 'en', 22, 'Page', 'deletePostEvent', 'label2', 'Page alias:'),
(386, 'en', 22, 'Page', 'deletePostEvent', 'link1', 'List all pages!'),
(387, 'en', 22, 'Page', 'deletePostEvent', 'message1', 'Post id is not correct.'),
(388, 'en', 22, 'Page', 'deletePostEvent', 'submitYes', 'Delete this post!'),
(389, 'en', 22, 'Page', 'deletePostEvent', 'title', 'Delete an Existing Post'),
(390, 'en', 22, 'Page', 'deleteSnippetEvent', 'afterField1', 'Snippet code:'),
(391, 'en', 22, 'Page', 'deleteSnippetEvent', 'afterMessage', 'Snippet with following details was deleted:'),
(392, 'en', 22, 'Page', 'deleteSnippetEvent', 'beforeField1', 'Snippet code:'),
(393, 'en', 22, 'Page', 'deleteSnippetEvent', 'beforeMessage', 'Are you sure, that you wish to delete the snippet with following details?'),
(394, 'en', 22, 'Page', 'deleteSnippetEvent', 'label1', 'Page title:'),
(395, 'en', 22, 'Page', 'deleteSnippetEvent', 'label2', 'Url alias:'),
(396, 'en', 22, 'Page', 'deleteSnippetEvent', 'label3', 'Start of page body:'),
(397, 'en', 22, 'Page', 'deleteSnippetEvent', 'link1', 'Show list of snippets!'),
(398, 'en', 22, 'Page', 'deleteSnippetEvent', 'message1', 'Snippet id is not correct.'),
(399, 'en', 22, 'Page', 'deleteSnippetEvent', 'submitYes', 'Delete this snippet!'),
(400, 'en', 22, 'Page', 'deleteSnippetEvent', 'title', 'Delete an Existing Snippet'),
(401, 'en', 21, 'Page', 'editAnyPageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(402, 'en', 21, 'Page', 'editAnyPageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(403, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/bodyArea', 'Main content of the page.'),
(404, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/botTag', 'Html meta tag for robots.'),
(405, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/caching', 'Choose, for which roles this page will be cached. Hold down Ctrl key to check multiple roles.'),
(406, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/descriptionArea', 'Description of the page for html description meta tag. Helps Search Engine Optimizing. If field is empty, then default site wide, default Page module or default view method description will be used.'),
(407, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/label', 'Human readable label for menu item (if this field is empty, then no menu item will be used for this page).'),
(408, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/menuId', 'Choose menu, where this item belongs to (if no menu is chosen, then no menu item will be used for this page).'),
(409, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/parentId', 'Choose parent item in the menu for the current menu item.'),
(410, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/roleAccess', 'Choose, which roles can view this page. Hold down Ctrl key to check multiple roles.'),
(411, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/status', 'Choose, whether this page is published or not. Good to use this option if page is not ready yet or in other occasions.'),
(412, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/title', 'Title of the page (usually used for html title tag and in h1 tag). This field should not be empty.'),
(413, 'en', 21, 'Page', 'editAnyPageEvent', 'guide/weight', 'Weight is an integer number, which determines order of menu items.'),
(414, 'en', 21, 'Page', 'editAnyPageEvent', 'label/alias', 'URL alias'),
(415, 'en', 21, 'Page', 'editAnyPageEvent', 'label/bodyArea', 'Body'),
(416, 'en', 21, 'Page', 'editAnyPageEvent', 'label/botTag', 'Robot meta tag'),
(417, 'en', 21, 'Page', 'editAnyPageEvent', 'label/caching', 'Caching for roles'),
(418, 'en', 21, 'Page', 'editAnyPageEvent', 'label/descriptionArea', 'Description meta tag'),
(419, 'en', 21, 'Page', 'editAnyPageEvent', 'label/label', 'Menu item label'),
(420, 'en', 21, 'Page', 'editAnyPageEvent', 'label/menuId', 'Menu'),
(421, 'en', 21, 'Page', 'editAnyPageEvent', 'label/parentId', 'Menu item location'),
(422, 'en', 21, 'Page', 'editAnyPageEvent', 'label/roleAccess', 'Access right for roles'),
(423, 'en', 21, 'Page', 'editAnyPageEvent', 'label/status', 'Page status'),
(424, 'en', 21, 'Page', 'editAnyPageEvent', 'label/title', 'Title'),
(425, 'en', 21, 'Page', 'editAnyPageEvent', 'label/weight', 'Weight'),
(426, 'en', 21, 'Page', 'editAnyPageEvent', 'value/submit1', 'Save'),
(427, 'en', 22, 'Page', 'editAnyPageEvent', 'botTagOption1', 'No tag (default - index, follow)'),
(428, 'en', 22, 'Page', 'editAnyPageEvent', 'link1', 'Show list of pages!'),
(429, 'en', 22, 'Page', 'editAnyPageEvent', 'link1b', 'View'),
(430, 'en', 22, 'Page', 'editAnyPageEvent', 'subTitle1', 'Main area'),
(431, 'en', 22, 'Page', 'editAnyPageEvent', 'subTitle2', 'Menu area'),
(432, 'en', 22, 'Page', 'editAnyPageEvent', 'subTitle3', 'Other options'),
(433, 'en', 22, 'Page', 'editAnyPageEvent', 'link4', 'List snippets!'),
(434, 'en', 22, 'Page', 'editAnyPageEvent', 'link5', 'Add a snippet!'),
(435, 'en', 22, 'Page', 'editAnyPageEvent', 'menuOption0', 'No menu is chosen'),
(436, 'en', 22, 'Page', 'editAnyPageEvent', 'message1', 'Page id is not correct!'),
(437, 'en', 22, 'Page', 'editAnyPageEvent', 'statusOption1', 'Published'),
(438, 'en', 22, 'Page', 'editAnyPageEvent', 'statusOption2', 'Not published'),
(439, 'en', 22, 'Page', 'editAnyPageEvent', 'submitMessage', 'Page was saved at'),
(440, 'en', 22, 'Page', 'editAnyPageEvent', 'title', 'Edit an Existing Page'),
(441, 'en', 21, 'Page', 'editPostEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(442, 'en', 21, 'Page', 'editPostEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(443, 'en', 21, 'Page', 'editPostEvent', 'guide/postContent', 'Content of the post.'),
(444, 'en', 21, 'Page', 'editPostEvent', 'guide/postStatus', 'Choose, whether this post is published or not.'),
(445, 'en', 21, 'Page', 'editPostEvent', 'label/postContent', 'Post content:'),
(446, 'en', 21, 'Page', 'editPostEvent', 'label/postStatus', 'Post status:'),
(447, 'en', 21, 'Page', 'editPostEvent', 'value/save', 'Save'),
(448, 'en', 22, 'Page', 'editPostEvent', 'message1', 'Post id is not correct.'),
(449, 'en', 22, 'Page', 'editPostEvent', 'message2', 'A post with such id does not exist or you have no access right to edit it.'),
(450, 'en', 22, 'Page', 'editPostEvent', 'message3', 'Page id is not correct.'),
(451, 'en', 22, 'Page', 'editPostEvent', 'submitMessage', 'Post was updated.'),
(452, 'en', 22, 'Page', 'editPostEvent', 'title', 'Edit an Existing Post'),
(453, 'en', 21, 'Page', 'editSnippetEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(454, 'en', 21, 'Page', 'editSnippetEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(455, 'en', 21, 'Page', 'editSnippetEvent', 'guide/snippetCode', 'An unique code to identify this snippet from all the other snippets of the current page.'),
(456, 'en', 21, 'Page', 'editSnippetEvent', 'guide/snippetContent', 'Content of the snippet.'),
(457, 'en', 21, 'Page', 'editSnippetEvent', 'guide/snippetType', 'If type is plain text, then the content form field should include text, which will be displayed in snippet. If type is PHP code, then it should include location to the PHP code class and then refer to method, which will return the snippet content in this class, separated by ";". For example, something like: custom/modules/[ModuleName]/Model/[ClassFileName.php];[methodName].'),
(458, 'en', 21, 'Page', 'editSnippetEvent', 'label/snippetCode', 'Unique snippet code:'),
(459, 'en', 21, 'Page', 'editSnippetEvent', 'label/snippetContent', 'Snippet content:'),
(460, 'en', 21, 'Page', 'editSnippetEvent', 'label/snippetType', 'Snippet type:'),
(461, 'en', 21, 'Page', 'editSnippetEvent', 'value/save', 'Save'),
(462, 'en', 22, 'Page', 'editSnippetEvent', 'field1', 'Snippet code:'),
(463, 'en', 22, 'Page', 'editSnippetEvent', 'label1', 'Page title:'),
(464, 'en', 22, 'Page', 'editSnippetEvent', 'label2', 'Url alias:'),
(465, 'en', 22, 'Page', 'editSnippetEvent', 'label3', 'Start of page body:'),
(466, 'en', 22, 'Page', 'editSnippetEvent', 'link1', 'Show list of snippets!'),
(467, 'en', 22, 'Page', 'editSnippetEvent', 'message1', 'Snippet id is not correct.'),
(468, 'en', 22, 'Page', 'editSnippetEvent', 'message2', 'A snippet with such id does not exist or you can not edit it.'),
(469, 'en', 22, 'Page', 'editSnippetEvent', 'title', 'Edit an Existing Snippet'),
(470, 'en', 22, 'Page', 'editSnippetEvent', 'typeOption1', 'Plain text'),
(471, 'en', 22, 'Page', 'editSnippetEvent', 'typeOption2', 'PHP code'),
(472, 'en', 22, 'Page', 'indexEvent', 'link1a', 'Add a new page'),
(473, 'en', 22, 'Page', 'indexEvent', 'link1b', 'List own pages'),
(474, 'en', 22, 'Page', 'indexEvent', 'link1c', 'List all pages'),
(475, 'en', 22, 'Page', 'indexEvent', 'link2', 'Edit'),
(476, 'en', 22, 'Page', 'indexEvent', 'link3', 'Delete'),
(477, 'en', 22, 'Page', 'indexEvent', 'link4', 'View source'),
(478, 'en', 22, 'Page', 'indexEvent', 'link5', 'View alias'),
(479, 'en', 22, 'Page', 'indexEvent', 'message1', 'There are no pages.'),
(480, 'en', 22, 'Page', 'indexEvent', 'statusOption1', 'Published'),
(481, 'en', 22, 'Page', 'indexEvent', 'statusOption2', 'Not published'),
(482, 'en', 22, 'Page', 'indexEvent', 'tb1BodyStart', 'Start of body'),
(483, 'en', 22, 'Page', 'indexEvent', 'tb1Created', 'Created'),
(484, 'en', 22, 'Page', 'indexEvent', 'tb1Creator', 'Creator'),
(485, 'en', 22, 'Page', 'indexEvent', 'tb1Modified', 'Modified'),
(486, 'en', 22, 'Page', 'indexEvent', 'tb1PageTitle', 'Title'),
(487, 'en', 22, 'Page', 'indexEvent', 'tb1Status', 'Status'),
(488, 'en', 22, 'Page', 'indexEvent', 'tb1Title', 'List of pages'),
(489, 'en', 22, 'Page', 'indexEvent', 'title', 'List of All Pages'),
(490, 'en', 22, 'Page', 'listAllPagesEvent', 'link1', 'Add a new page'),
(491, 'en', 22, 'Page', 'listAllPagesEvent', 'link2', 'Edit'),
(492, 'en', 22, 'Page', 'listAllPagesEvent', 'link3', 'Delete'),
(493, 'en', 22, 'Page', 'listAllPagesEvent', 'link4', 'View source'),
(494, 'en', 22, 'Page', 'listAllPagesEvent', 'link5', 'View alias'),
(495, 'en', 22, 'Page', 'listAllPagesEvent', 'message1', 'There are no pages.'),
(496, 'en', 22, 'Page', 'listAllPagesEvent', 'statusOption1', 'Published'),
(497, 'en', 22, 'Page', 'listAllPagesEvent', 'statusOption2', 'Not published'),
(498, 'en', 22, 'Page', 'listAllPagesEvent', 'tb1BodyStart', 'Start of body'),
(499, 'en', 22, 'Page', 'listAllPagesEvent', 'tb1Created', 'Created'),
(500, 'en', 22, 'Page', 'listAllPagesEvent', 'tb1Creator', 'Creator'),
(501, 'en', 22, 'Page', 'listAllPagesEvent', 'tb1Modified', 'Modified'),
(502, 'en', 22, 'Page', 'listAllPagesEvent', 'tb1PageTitle', 'Title'),
(503, 'en', 22, 'Page', 'listAllPagesEvent', 'tb1Status', 'Status'),
(504, 'en', 22, 'Page', 'listAllPagesEvent', 'tb1Title', 'List of pages'),
(505, 'en', 22, 'Page', 'listAllPagesEvent', 'title', 'List of All Pages'),
(506, 'en', 22, 'Page', 'listSnippetsEvent', 'label1', 'Page title:'),
(507, 'en', 22, 'Page', 'listSnippetsEvent', 'label2', 'Url alias:'),
(508, 'en', 22, 'Page', 'listSnippetsEvent', 'label3', 'Start of page body:'),
(509, 'en', 22, 'Page', 'listSnippetsEvent', 'link1', 'Add snippet'),
(510, 'en', 22, 'Page', 'listSnippetsEvent', 'link2', 'Edit'),
(511, 'en', 22, 'Page', 'listSnippetsEvent', 'link3', 'Delete'),
(512, 'en', 22, 'Page', 'listSnippetsEvent', 'message1', 'Page id is not correct.'),
(513, 'en', 22, 'Page', 'listSnippetsEvent', 'message2', 'There are no snippets for this page.'),
(514, 'en', 22, 'Page', 'listSnippetsEvent', 'tb1SnCode', 'Snippet code'),
(515, 'en', 22, 'Page', 'listSnippetsEvent', 'tb1SnContent', 'Snippet content'),
(516, 'en', 22, 'Page', 'listSnippetsEvent', 'title', 'List of Snippets'),
(517, 'en', 21, 'Page', 'managePostingAccessEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(518, 'en', 21, 'Page', 'managePostingAccessEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(519, 'en', 21, 'Page', 'managePostingAccessEvent', 'guide/postingAccess', 'Tick this box to allow posting by other visitors on the corresponding page or untick it, if you wish not to allow such posting!'),
(520, 'en', 21, 'Page', 'managePostingAccessEvent', 'guide/postingIntro', 'Write some introduction to let people know, that they can post comments to this page.'),
(521, 'en', 21, 'Page', 'managePostingAccessEvent', 'guide/postStatus', 'Choose, whether a post is after writing it by default published or not.'),
(522, 'en', 21, 'Page', 'managePostingAccessEvent', 'label/postingIntro', 'Posting introduction:'),
(523, 'en', 21, 'Page', 'managePostingAccessEvent', 'label/postStatus', 'Post default status:'),
(524, 'en', 21, 'Page', 'managePostingAccessEvent', 'value/save', 'Save'),
(525, 'en', 22, 'Page', 'managePostingAccessEvent', 'intro', 'This post is related to page...'),
(526, 'en', 22, 'Page', 'managePostingAccessEvent', 'label-postingAccess', 'Posting enabled'),
(527, 'en', 22, 'Page', 'managePostingAccessEvent', 'label1', 'Page title:'),
(528, 'en', 22, 'Page', 'managePostingAccessEvent', 'label2', 'Page alias:'),
(529, 'en', 22, 'Page', 'managePostingAccessEvent', 'message1', 'Page id is not correct.'),
(530, 'en', 22, 'Page', 'managePostingAccessEvent', 'title', 'Manage Posting Access'),
(531, 'en', 22, 'Page', 'viewEvent', 'link1', 'Edit'),
(532, 'en', 22, 'Page', 'viewEvent', 'postCreatorLabel', 'Created by:'),
(533, 'en', 22, 'Page', 'viewEvent', 'postEditorLabel', 'Edited by:'),
(534, 'en', 22, 'Page', 'viewEvent', 'postError1', 'Field “[elLabel]” is invalid!'),
(535, 'en', 22, 'Page', 'viewEvent', 'postError2', 'Captcha code is not correct.'),
(536, 'en', 22, 'Page', 'viewEvent', 'postLabel1', 'Your name *'),
(537, 'en', 22, 'Page', 'viewEvent', 'postLabel2', 'Your email *'),
(538, 'en', 22, 'Page', 'viewEvent', 'postLabel3', 'Your comment *'),
(539, 'en', 22, 'Page', 'viewEvent', 'postLink1', 'Edit post'),
(540, 'en', 22, 'Page', 'viewEvent', 'postLink2', 'Delete post'),
(541, 'en', 22, 'Page', 'viewEvent', 'postLink3', 'Manage posting access'),
(542, 'en', 22, 'Page', 'viewEvent', 'postNote1', 'Not published'),
(543, 'en', 22, 'Page', 'viewEvent', 'postSubmit', 'Submit comment'),
(544, 'en', 22, 'Page', 'viewEvent', 'captchaNewCode', 'Get another code'),
(545, 'en', 22, 'Page', 'viewEvent', 'captchaBoxLabel', 'Type the characters in the image'),
(546, 'en', 21, 'Profile', 'indexEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(547, 'en', 21, 'Profile', 'indexEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(548, 'en', 21, 'Profile', 'indexEvent', 'guide/gravatarSource', 'Change the case (capital or lower case) of the letters of your email address and click Refresh images to get different avatar images. Gravatar service is used to compose most of the images - see https://en.gravatar.com/.'),
(549, 'en', 21, 'Profile', 'indexEvent', 'guide/personalNotes', 'You can write and keep here some personal notes - up to 2040 characters.'),
(550, 'en', 21, 'Profile', 'indexEvent', 'label/gravatarSource', 'Gravatar source');
INSERT INTO `core_language` (`id`, `language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
(551, 'en', 21, 'Profile', 'indexEvent', 'label/personalNotes', 'Personal notes'),
(552, 'en', 21, 'Profile', 'indexEvent', 'value/refreshImages', 'Refresh images'),
(553, 'en', 21, 'Profile', 'indexEvent', 'value/getEmailAddress', 'Get email address'),
(554, 'en', 21, 'Profile', 'indexEvent', 'value/save', 'Save'),
(555, 'en', 22, 'Profile', 'indexEvent', 'message1', 'Avatar image source must be your email address!'),
(556, 'en', 22, 'Profile', 'indexEvent', 'message2', 'User id is not correct!'),
(557, 'en', 22, 'Profile', 'indexEvent', 'imageSetLabel', 'Avatar image'),
(558, 'en', 22, 'Profile', 'indexEvent', 'title', 'User Profile'),
(559, 'en', 21, 'Profile', 'indexEvent', 'label/langCode', 'Default language'),
(560, 'en', 21, 'Profile', 'indexEvent', 'guide/langCode', 'This default language may be used, if system decides in what language to send automated messages without any other information, what language would user prefer.'),
(561, 'en', 21, 'OwnPage', 'addSnippetEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(562, 'en', 21, 'OwnPage', 'addSnippetEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(563, 'en', 21, 'OwnPage', 'addSnippetEvent', 'guide/snippetCode', 'An unique code to identify this snippet from all the other snippets of the current page.'),
(564, 'en', 21, 'OwnPage', 'addSnippetEvent', 'guide/snippetContent', 'Content of the snippet.'),
(565, 'en', 21, 'OwnPage', 'addSnippetEvent', 'guide/snippetType', 'If type is plain text, then the content form field should include text, which will be displayed in snippet. If type is PHP code, then it should include location to the PHP code class and then refer to method, which will return the snippet content in this class, separated by ";". For example, something like: custom/modules/[ModuleName]/Model/[ClassFileName.php];[methodName].'),
(566, 'en', 21, 'OwnPage', 'addSnippetEvent', 'label/snippetCode', 'Unique snippet code:'),
(567, 'en', 21, 'OwnPage', 'addSnippetEvent', 'label/snippetContent', 'Snippet content:'),
(568, 'en', 21, 'OwnPage', 'addSnippetEvent', 'label/snippetType', 'Snippet type:'),
(569, 'en', 21, 'OwnPage', 'addSnippetEvent', 'value/save', 'Save'),
(570, 'en', 22, 'OwnPage', 'addSnippetEvent', 'label1', 'Page title:'),
(571, 'en', 22, 'OwnPage', 'addSnippetEvent', 'link1', 'Show list of snippets'),
(572, 'en', 22, 'OwnPage', 'addSnippetEvent', 'link2', 'Show parent page'),
(573, 'en', 22, 'OwnPage', 'addSnippetEvent', 'message1', 'You can not add snippets to this page, because this is not your page .'),
(574, 'en', 22, 'OwnPage', 'addSnippetEvent', 'message2', 'A page with such id does not exist.'),
(575, 'en', 22, 'OwnPage', 'addSnippetEvent', 'pageText2', 'Url alias:'),
(576, 'en', 22, 'OwnPage', 'addSnippetEvent', 'pageText3', 'Start of page body:'),
(577, 'en', 22, 'OwnPage', 'addSnippetEvent', 'title', 'Add a New Snippet'),
(578, 'en', 22, 'OwnPage', 'addSnippetEvent', 'typeOption1', 'Plain text'),
(579, 'en', 22, 'OwnPage', 'addSnippetEvent', 'typeOption2', 'PHP code'),
(580, 'en', 22, 'OwnPage', 'deletePageEvent', 'afterField1', 'title'),
(581, 'en', 22, 'OwnPage', 'deletePageEvent', 'afterMessage', 'The page with following details was deleted:'),
(582, 'en', 22, 'OwnPage', 'deletePageEvent', 'beforeField1', 'title is'),
(583, 'en', 22, 'OwnPage', 'deletePageEvent', 'beforeMessage', 'Are you sure, that you wish to delete the page with following details?'),
(584, 'en', 22, 'OwnPage', 'deletePageEvent', 'link1', 'Show list of pages!'),
(585, 'en', 22, 'OwnPage', 'deletePageEvent', 'message1', 'You can not delete this page, because it is not your page.'),
(586, 'en', 22, 'OwnPage', 'deletePageEvent', 'message2', 'Page id is not correct!'),
(587, 'en', 22, 'OwnPage', 'deletePageEvent', 'submitYes', 'Delete this page!'),
(588, 'en', 22, 'OwnPage', 'deletePageEvent', 'title', 'Delete Page'),
(589, 'en', 22, 'OwnPage', 'deletePostEvent', 'afterField1', 'Creator:'),
(590, 'en', 22, 'OwnPage', 'deletePostEvent', 'afterField2', 'Posting time:'),
(591, 'en', 22, 'OwnPage', 'deletePostEvent', 'afterField3', 'Start of content:'),
(592, 'en', 22, 'OwnPage', 'deletePostEvent', 'afterMessage', 'Post with following details was deleted:'),
(593, 'en', 22, 'OwnPage', 'deletePostEvent', 'beforeField1', 'Creator is:'),
(594, 'en', 22, 'OwnPage', 'deletePostEvent', 'beforeField2', 'Posting time is:'),
(595, 'en', 22, 'OwnPage', 'deletePostEvent', 'beforeField3', 'Start of content is:'),
(596, 'en', 22, 'OwnPage', 'deletePostEvent', 'beforeMessage', 'Are you sure, that you wish to delete the post with following details?'),
(597, 'en', 22, 'OwnPage', 'deletePostEvent', 'intro', 'This post is related to page...'),
(598, 'en', 22, 'OwnPage', 'deletePostEvent', 'label1', 'Page title:'),
(599, 'en', 22, 'OwnPage', 'deletePostEvent', 'label2', 'Page alias:'),
(600, 'en', 22, 'OwnPage', 'deletePostEvent', 'link1', 'List own pages'),
(601, 'en', 22, 'OwnPage', 'deletePostEvent', 'message1', 'You can not delete this post.'),
(602, 'en', 22, 'OwnPage', 'deletePostEvent', 'message2', 'Post id is not correct.'),
(603, 'en', 22, 'OwnPage', 'deletePostEvent', 'submitYes', 'Delete this post!'),
(604, 'en', 22, 'OwnPage', 'deletePostEvent', 'title', 'Delete Your Post or Post of Your Page'),
(605, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'afterField1', 'Snippet code:'),
(606, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'afterMessage', 'Snippet with following details was deleted:'),
(607, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'beforeField1', 'Snippet code:'),
(608, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'beforeMessage', 'Are you sure, that you wish to delete the snippet with following details?'),
(609, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'label1', 'Page title:'),
(610, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'label2', 'Url alias:'),
(611, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'label3', 'Start of page body:'),
(612, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'link1', 'Show list of snippets!'),
(613, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'link2', 'Show parent page'),
(614, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'message1', 'Snippet id is not correct.'),
(615, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'message2', 'A snippet with such id does not exist or you can not delete it.'),
(616, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'title', 'Delete an Existing Snippet'),
(617, 'en', 21, 'OwnPage', 'editPageEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(618, 'en', 21, 'OwnPage', 'editPageEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(619, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/bodyArea', 'Main content of the page.'),
(620, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/botTag', 'Html meta tag for robots.'),
(621, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/caching', 'Choose, for which roles this page will be cached. Hold down Ctrl key to check multiple roles.'),
(622, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/descriptionArea', 'Description of the page for html description meta tag. Helps Search Engine Optimizing. If field is empty, then default site wide, default Page module or default view method description will be used.'),
(623, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/label', 'Human readable label for menu item (if this field is empty, then no menu item will be used for this page).'),
(624, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/menuId', 'Choose menu, where this item belongs to (if no menu is chosen, then no menu item will be used for this page).'),
(625, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/parentId', 'Choose parent item in the menu for the current menu item.'),
(626, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/roleAccess', 'Choose, which roles can view this page. Hold down Ctrl key to check multiple roles.'),
(627, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/status', 'Choose, whether this page is published or not. Good to use this option if page is not ready yet or in other occasions.'),
(628, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/title', 'Title of the page (usually used for html title tag and in h1 tag). This field should not be empty.'),
(629, 'en', 21, 'OwnPage', 'editPageEvent', 'guide/weight', 'Weight is an integer number, which determines order of menu items.'),
(630, 'en', 21, 'OwnPage', 'editPageEvent', 'label/alias', 'URL alias'),
(631, 'en', 21, 'OwnPage', 'editPageEvent', 'label/bodyArea', 'Body'),
(632, 'en', 21, 'OwnPage', 'editPageEvent', 'label/botTag', 'Robot meta tag'),
(633, 'en', 21, 'OwnPage', 'editPageEvent', 'label/caching', 'Caching for roles'),
(634, 'en', 21, 'OwnPage', 'editPageEvent', 'label/descriptionArea', 'Description meta tag'),
(635, 'en', 21, 'OwnPage', 'editPageEvent', 'label/label', 'Menu item label'),
(636, 'en', 21, 'OwnPage', 'editPageEvent', 'label/menuId', 'Menu'),
(637, 'en', 21, 'OwnPage', 'editPageEvent', 'label/parentId', 'Menu item location'),
(638, 'en', 21, 'OwnPage', 'editPageEvent', 'label/roleAccess', 'Access right for roles'),
(639, 'en', 21, 'OwnPage', 'editPageEvent', 'label/status', 'Page status'),
(640, 'en', 21, 'OwnPage', 'editPageEvent', 'label/title', 'Title'),
(641, 'en', 21, 'OwnPage', 'editPageEvent', 'label/weight', 'Weight'),
(642, 'en', 21, 'OwnPage', 'editPageEvent', 'value/submit1', 'Save'),
(643, 'en', 22, 'OwnPage', 'editPageEvent', 'botTagOption1', 'No tag (default - index, follow)'),
(644, 'en', 22, 'OwnPage', 'editPageEvent', 'link1', 'List own pages!'),
(645, 'en', 22, 'OwnPage', 'editPageEvent', 'link1b', 'View'),
(646, 'en', 22, 'OwnPage', 'editPageEvent', 'subTitle1', 'Main area'),
(647, 'en', 22, 'OwnPage', 'editPageEvent', 'subTitle2', 'Menu area'),
(648, 'en', 22, 'OwnPage', 'editPageEvent', 'subTitle3', 'Other options'),
(649, 'en', 22, 'OwnPage', 'editPageEvent', 'link4', 'List snippets!'),
(650, 'en', 22, 'OwnPage', 'editPageEvent', 'link5', 'Add a snippet!'),
(651, 'en', 22, 'OwnPage', 'editPageEvent', 'menuOption0', 'No menu is chosen'),
(652, 'en', 22, 'OwnPage', 'editPageEvent', 'message1', 'You can not edit this page, because it is not your page.'),
(653, 'en', 22, 'OwnPage', 'editPageEvent', 'message2', 'Page id is not correct!'),
(654, 'en', 22, 'OwnPage', 'editPageEvent', 'statusOption1', 'Published'),
(655, 'en', 22, 'OwnPage', 'editPageEvent', 'statusOption2', 'Not published'),
(656, 'en', 22, 'OwnPage', 'editPageEvent', 'submitMessage', 'Page was saved at'),
(657, 'en', 22, 'OwnPage', 'editPageEvent', 'title', 'Edit an Existing Own Page'),
(658, 'en', 21, 'OwnPage', 'editPostEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(659, 'en', 21, 'OwnPage', 'editPostEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(660, 'en', 21, 'OwnPage', 'editPostEvent', 'guide/postContent', 'Content of the post.'),
(661, 'en', 21, 'OwnPage', 'editPostEvent', 'guide/postStatus', 'Choose, whether this post is published or not.'),
(662, 'en', 21, 'OwnPage', 'editPostEvent', 'label/postContent', 'Post content:'),
(663, 'en', 21, 'OwnPage', 'editPostEvent', 'label/postStatus', 'Post status:'),
(664, 'en', 21, 'OwnPage', 'editPostEvent', 'value/save', 'Save'),
(665, 'en', 22, 'OwnPage', 'editPostEvent', 'message1', 'Post id is not correct.'),
(666, 'en', 22, 'OwnPage', 'editPostEvent', 'message2', 'A post with such id does not exist or you have no access right to edit it.'),
(667, 'en', 22, 'OwnPage', 'editPostEvent', 'message3', 'Page id is not correct.'),
(668, 'en', 22, 'OwnPage', 'editPostEvent', 'submitMessage', 'Post was updated.'),
(669, 'en', 22, 'OwnPage', 'editPostEvent', 'title', 'Edit an Existing Post'),
(670, 'en', 21, 'OwnPage', 'editSnippetEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(671, 'en', 21, 'OwnPage', 'editSnippetEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(672, 'en', 21, 'OwnPage', 'editSnippetEvent', 'guide/snippetCode', 'An unique code to identify this snippet from all the other snippets of the current page.'),
(673, 'en', 21, 'OwnPage', 'editSnippetEvent', 'guide/snippetContent', 'Content of the snippet.'),
(674, 'en', 21, 'OwnPage', 'editSnippetEvent', 'guide/snippetType', 'If type is plain text, then the content form field should include text, which will be displayed in snippet. If type is PHP code, then it should include location to the PHP code class and then refer to method, which will return the snippet content in this class, separated by ";". For example, something like: custom/modules/[ModuleName]/Model/[ClassFileName.php];[methodName].'),
(675, 'en', 21, 'OwnPage', 'editSnippetEvent', 'label/snippetCode', 'Unique snippet code:'),
(676, 'en', 21, 'OwnPage', 'editSnippetEvent', 'label/snippetContent', 'Snippet content:'),
(677, 'en', 21, 'OwnPage', 'editSnippetEvent', 'label/snippetType', 'Snippet type:'),
(678, 'en', 21, 'OwnPage', 'editSnippetEvent', 'value/save', 'Save'),
(679, 'en', 22, 'OwnPage', 'editSnippetEvent', 'field1', 'Snippet code:'),
(680, 'en', 22, 'OwnPage', 'editSnippetEvent', 'label1', 'Page title:'),
(681, 'en', 22, 'OwnPage', 'editSnippetEvent', 'label2', 'Url alias:'),
(682, 'en', 22, 'OwnPage', 'editSnippetEvent', 'label3', 'Start of page body:'),
(683, 'en', 22, 'OwnPage', 'editSnippetEvent', 'link1', 'Show list of snippets'),
(684, 'en', 22, 'OwnPage', 'editSnippetEvent', 'link2', 'Show parent page'),
(685, 'en', 22, 'OwnPage', 'editSnippetEvent', 'message1', 'Snippet id is not correct.'),
(686, 'en', 22, 'OwnPage', 'editSnippetEvent', 'message2', 'A snippet with such id does not exist or you can not edit it.'),
(687, 'en', 22, 'OwnPage', 'editSnippetEvent', 'title', 'Edit an Existing Snippet'),
(688, 'en', 22, 'OwnPage', 'editSnippetEvent', 'typeOption1', 'Plain text'),
(689, 'en', 22, 'OwnPage', 'editSnippetEvent', 'typeOption2', 'PHP code'),
(690, 'en', 22, 'OwnPage', 'indexEvent', 'link1a', 'Add a new page'),
(691, 'en', 22, 'OwnPage', 'indexEvent', 'link1b', 'List own pages'),
(692, 'en', 22, 'OwnPage', 'indexEvent', 'link1c', 'List all pages'),
(693, 'en', 22, 'OwnPage', 'indexEvent', 'link2', 'Edit'),
(694, 'en', 22, 'OwnPage', 'indexEvent', 'link3', 'Delete'),
(695, 'en', 22, 'OwnPage', 'indexEvent', 'link4', 'View source'),
(696, 'en', 22, 'OwnPage', 'indexEvent', 'link5', 'View alias'),
(697, 'en', 22, 'OwnPage', 'indexEvent', 'message1', 'There are no pages.'),
(698, 'en', 22, 'OwnPage', 'indexEvent', 'statusOption1', 'Published'),
(699, 'en', 22, 'OwnPage', 'indexEvent', 'statusOption2', 'Not published'),
(700, 'en', 22, 'OwnPage', 'indexEvent', 'tb1BodyStart', 'Start of body'),
(701, 'en', 22, 'OwnPage', 'indexEvent', 'tb1Created', 'Created'),
(702, 'en', 22, 'OwnPage', 'indexEvent', 'tb1Creator', 'Creator'),
(703, 'en', 22, 'OwnPage', 'indexEvent', 'tb1Modified', 'Modified'),
(704, 'en', 22, 'OwnPage', 'indexEvent', 'tb1PageTitle', 'Title'),
(705, 'en', 22, 'OwnPage', 'indexEvent', 'tb1Status', 'Status'),
(706, 'en', 22, 'OwnPage', 'indexEvent', 'tb1Title', 'List of pages'),
(707, 'en', 22, 'OwnPage', 'indexEvent', 'title', 'List of Own Pages'),
(708, 'en', 22, 'OwnPage', 'listPagesEvent', 'link1', 'Add a new page'),
(709, 'en', 22, 'OwnPage', 'listPagesEvent', 'link2', 'Edit'),
(710, 'en', 22, 'OwnPage', 'listPagesEvent', 'link3', 'Delete'),
(711, 'en', 22, 'OwnPage', 'listPagesEvent', 'link4', 'View source'),
(712, 'en', 22, 'OwnPage', 'listPagesEvent', 'link5', 'View alias'),
(713, 'en', 22, 'OwnPage', 'listPagesEvent', 'message1', 'There are no pages.'),
(714, 'en', 22, 'OwnPage', 'listPagesEvent', 'statusOption1', 'Published'),
(715, 'en', 22, 'OwnPage', 'listPagesEvent', 'statusOption2', 'Not published'),
(716, 'en', 22, 'OwnPage', 'listPagesEvent', 'tb1BodyStart', 'Start of body'),
(717, 'en', 22, 'OwnPage', 'listPagesEvent', 'tb1Created', 'Created'),
(718, 'en', 22, 'OwnPage', 'listPagesEvent', 'tb1Modified', 'Modified'),
(719, 'en', 22, 'OwnPage', 'listPagesEvent', 'tb1PageTitle', 'Title'),
(720, 'en', 22, 'OwnPage', 'listPagesEvent', 'tb1Status', 'Status'),
(721, 'en', 22, 'OwnPage', 'listPagesEvent', 'tb1Title', 'List of pages'),
(722, 'en', 22, 'OwnPage', 'listPagesEvent', 'title', 'List of Own Pages'),
(723, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'label1', 'Page title:'),
(724, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'link1', 'Add a new snippet'),
(725, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'link2', 'Edit parent page'),
(726, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'link3', 'Edit'),
(727, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'link4', 'Delete'),
(728, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'message1', 'There are no snippets for this page.'),
(729, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'message2', 'You can not list snippets of this page, because this is not your page.'),
(730, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'message3', 'Page id is not correct.'),
(731, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'tb1SnCode', 'Snippet code'),
(732, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'tb1SnContent', 'Snippet content'),
(733, 'en', 22, 'OwnPage', 'listSnippetsEvent', 'title', 'List Snippets'),
(734, 'en', 21, 'OwnPage', 'managePostingAccessEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(735, 'en', 21, 'OwnPage', 'managePostingAccessEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(736, 'en', 21, 'OwnPage', 'managePostingAccessEvent', 'guide/postingAccess', 'Tick this box to allow posting by other visitors on the corresponding page or untick it, if you wish not to allow such posting!'),
(737, 'en', 21, 'OwnPage', 'managePostingAccessEvent', 'guide/postingIntro', 'Write some introduction to let people know, that they can post comments to this page.'),
(738, 'en', 21, 'OwnPage', 'managePostingAccessEvent', 'guide/postStatus', 'Choose, whether a post is after writing it by default published or not.'),
(739, 'en', 21, 'OwnPage', 'managePostingAccessEvent', 'label/postingIntro', 'Posting introduction:'),
(740, 'en', 21, 'OwnPage', 'managePostingAccessEvent', 'label/postStatus', 'Post default status:'),
(741, 'en', 21, 'OwnPage', 'managePostingAccessEvent', 'value/save', 'Save'),
(742, 'en', 22, 'OwnPage', 'managePostingAccessEvent', 'intro', 'This post is related to page...'),
(743, 'en', 22, 'OwnPage', 'managePostingAccessEvent', 'label-postingAccess', 'Posting enabled'),
(744, 'en', 22, 'OwnPage', 'managePostingAccessEvent', 'label1', 'Page title:'),
(745, 'en', 22, 'OwnPage', 'managePostingAccessEvent', 'label2', 'Page alias:'),
(746, 'en', 22, 'OwnPage', 'managePostingAccessEvent', 'message1', 'Page id is not correct.'),
(747, 'en', 22, 'OwnPage', 'managePostingAccessEvent', 'title', 'Manage Posting Access'),
(748, 'en', 21, 'User', 'addAccountEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(749, 'en', 21, 'User', 'addAccountEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(750, 'en', 21, 'User', 'addAccountEvent', 'guide/email', ''),
(751, 'en', 21, 'User', 'addAccountEvent', 'guide/password', ''),
(752, 'en', 21, 'User', 'addAccountEvent', 'guide/username', ''),
(753, 'en', 21, 'User', 'addAccountEvent', 'label/email', 'E-mail*:'),
(754, 'en', 21, 'User', 'addAccountEvent', 'label/password', 'Password*:'),
(755, 'en', 21, 'User', 'addAccountEvent', 'label/username', 'Username*:'),
(756, 'en', 21, 'User', 'addAccountEvent', 'value/register', 'Register'),
(757, 'en', 22, 'User', 'addAccountEvent', 'link1', 'Show list of user accounts!'),
(758, 'en', 22, 'User', 'addAccountEvent', 'message1', 'New user account was added.'),
(759, 'en', 22, 'User', 'addAccountEvent', 'message2', 'This e-mail address has been already registered.'),
(760, 'en', 22, 'User', 'addAccountEvent', 'message3', 'This username has been already registered.'),
(761, 'en', 22, 'User', 'addAccountEvent', 'title', 'Add a New User Account'),
(762, 'en', 21, 'User', 'addAnyContactFormEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(763, 'en', 21, 'User', 'addAnyContactFormEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(764, 'en', 21, 'User', 'addAnyContactFormEvent', 'guide/contactName', ''),
(765, 'en', 21, 'User', 'addAnyContactFormEvent', 'guide/description', ''),
(766, 'en', 21, 'User', 'addAnyContactFormEvent', 'guide/emailId', 'Choose your verified email address, where the messages of this contact forms will be sent to.'),
(767, 'en', 21, 'User', 'addAnyContactFormEvent', 'guide/status', 'Active is meaning, that the form can be used by other people; passive is meaning that it can not be used.'),
(768, 'en', 21, 'User', 'addAnyContactFormEvent', 'guide/userId', ''),
(769, 'en', 21, 'User', 'addAnyContactFormEvent', 'label/contactName', 'Contact name:'),
(770, 'en', 21, 'User', 'addAnyContactFormEvent', 'label/description', 'Contact form description:'),
(771, 'en', 21, 'User', 'addAnyContactFormEvent', 'label/emailId', 'Email:'),
(772, 'en', 21, 'User', 'addAnyContactFormEvent', 'label/status', 'Contact status:'),
(773, 'en', 21, 'User', 'addAnyContactFormEvent', 'label/userId', 'Choose user:'),
(774, 'en', 21, 'User', 'addAnyContactFormEvent', 'value/save', 'Save'),
(775, 'en', 22, 'User', 'addAnyContactFormEvent', 'link1', 'Show list of all contact forms!'),
(776, 'en', 22, 'User', 'addAnyContactFormEvent', 'message1', 'There are no verified email addresses.'),
(777, 'en', 22, 'User', 'addAnyContactFormEvent', 'statusOption0', 'Passive'),
(778, 'en', 22, 'User', 'addAnyContactFormEvent', 'statusOption1', 'Active'),
(779, 'en', 22, 'User', 'addAnyContactFormEvent', 'title', 'Add a New Contact Form'),
(780, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(781, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(782, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'guide/comment', 'Any comment, which you wish to add.'),
(783, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'guide/emailAddress', ''),
(784, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'guide/memWord', 'If you see the form field Memorable word, then this means, that your e-mail address is related to such word and you must submit both (your email address and such a word) to ask for a new password and username.'),
(785, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'guide/memWordQuestion', 'Question to remind the memorable word.'),
(786, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'guide/userId', ''),
(787, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'label/comment', 'Comment:'),
(788, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'label/emailAddress', 'Email address*:'),
(789, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'label/memWord', 'Memorable word:'),
(790, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'label/memWordQuestion', 'Memorable word question:'),
(791, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'label/userId', 'Choose user:'),
(792, 'en', 21, 'User', 'addAnyEmailAddressEvent', 'value/save', 'Save'),
(793, 'en', 22, 'User', 'addAnyEmailAddressEvent', 'link1', 'Show list of all email addresses!'),
(794, 'en', 22, 'User', 'addAnyEmailAddressEvent', 'message1', 'Authentication email address (username) and/or password are not configured.'),
(795, 'en', 22, 'User', 'addAnyEmailAddressEvent', 'message2', 'A link was sent to your e-mail address. Please check out your e-mail address and validate your email by clicking on this link.'),
(796, 'en', 22, 'User', 'addAnyEmailAddressEvent', 'message3', 'This e-mail address has been already registered.'),
(797, 'en', 22, 'User', 'addAnyEmailAddressEvent', 'title', 'Add a New Email Address'),
(798, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(799, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(800, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/addressLine1', 'Street, house number or name, flat number (if any).'),
(801, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/addressLine2', 'City or town or village or other similar administrative division.'),
(802, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/addressLine3', 'County.'),
(803, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/addressLine4', 'State or province or other similar administrative region. If there was no option for your country in drop-down menu and you chose there last option \"other\", then please write your country here.'),
(804, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/comment', 'Any additional comment, which you wish to submit.'),
(805, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/country', 'If your country is not in the list, then please choose the closest country (or last option Other) and describe your country name in comment field.'),
(806, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/postalAddress', 'Whole postal address as it appears on official letters in your country. Your local official address format.'),
(807, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/postCode', 'Postal code or zip code or other similar code.'),
(808, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/title', 'Unique (human readable) title to distinguish postal addresses from one another.'),
(809, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'guide/userId', ''),
(810, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/addressLine1', 'Street, house, flat:'),
(811, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/addressLine2', 'City / Town / Village:'),
(812, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/addressLine3', 'County:'),
(813, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/addressLine4', 'State / Province / Region:'),
(814, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/comment', 'Comment:'),
(815, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/country', 'Country*:'),
(816, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/postalAddress', 'Postal address*:'),
(817, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/postCode', 'Postal code:'),
(818, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/title', 'Postal address title:'),
(819, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'label/userId', 'Choose user:'),
(820, 'en', 21, 'User', 'addAnyPostalAddressEvent', 'value/save', 'Save'),
(821, 'en', 22, 'User', 'addAnyPostalAddressEvent', 'link1', 'Show list of all postal addresses!'),
(822, 'en', 22, 'User', 'addAnyPostalAddressEvent', 'title', 'Add a New Postal Address'),
(823, 'en', 21, 'User', 'addContactFormEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(824, 'en', 21, 'User', 'addContactFormEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(825, 'en', 21, 'User', 'addContactFormEvent', 'guide/contactName', ''),
(826, 'en', 21, 'User', 'addContactFormEvent', 'guide/description', ''),
(827, 'en', 21, 'User', 'addContactFormEvent', 'guide/emailId', 'Choose your verified email address, where the messages of this contact forms will be sent to.'),
(828, 'en', 21, 'User', 'addContactFormEvent', 'guide/status', 'Active is meaning, that the form can be used by other people; passive is meaning that it can not be used.'),
(829, 'en', 21, 'User', 'addContactFormEvent', 'label/contactName', 'Contact name:'),
(830, 'en', 21, 'User', 'addContactFormEvent', 'label/description', 'Contact form description:'),
(831, 'en', 21, 'User', 'addContactFormEvent', 'label/emailId', 'Email:'),
(832, 'en', 21, 'User', 'addContactFormEvent', 'label/status', 'Contact status:'),
(833, 'en', 21, 'User', 'addContactFormEvent', 'value/save', 'Save'),
(834, 'en', 22, 'User', 'addContactFormEvent', 'statusOption0', 'Passive'),
(835, 'en', 22, 'User', 'addContactFormEvent', 'statusOption1', 'Active'),
(836, 'en', 22, 'User', 'addContactFormEvent', 'link1', 'Show list of my contact forms!'),
(837, 'en', 22, 'User', 'addContactFormEvent', 'message1', 'There are no verified email addresses.'),
(838, 'en', 22, 'User', 'addContactFormEvent', 'title', 'Add a New Contact Form for My Account'),
(839, 'en', 21, 'User', 'addEmailAddressEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(840, 'en', 21, 'User', 'addEmailAddressEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(841, 'en', 21, 'User', 'addEmailAddressEvent', 'guide/comment', 'Any comment, which you wish to add.'),
(842, 'en', 21, 'User', 'addEmailAddressEvent', 'guide/emailAddress', ''),
(843, 'en', 21, 'User', 'addEmailAddressEvent', 'guide/memWord', 'If you see the form field Memorable word, then this means, that your e-mail address is related to such word and you must submit both (your email address and such a word) to ask for a new password and username.'),
(844, 'en', 21, 'User', 'addEmailAddressEvent', 'guide/memWordQuestion', 'Question to remind the memorable word.'),
(845, 'en', 21, 'User', 'addEmailAddressEvent', 'label/comment', 'Comment:'),
(846, 'en', 21, 'User', 'addEmailAddressEvent', 'label/emailAddress', 'Email address*:'),
(847, 'en', 21, 'User', 'addEmailAddressEvent', 'label/memWord', 'Memorable word:'),
(848, 'en', 21, 'User', 'addEmailAddressEvent', 'label/memWordQuestion', 'Memorable word question:'),
(849, 'en', 21, 'User', 'addEmailAddressEvent', 'value/save', 'Save'),
(850, 'en', 22, 'User', 'addEmailAddressEvent', 'link1', 'Show list of my email addresses!'),
(851, 'en', 22, 'User', 'addEmailAddressEvent', 'message1', 'Authentication email address (username) and/or password are not configured.'),
(852, 'en', 22, 'User', 'addEmailAddressEvent', 'message2', 'A link was sent to your e-mail address. Please check out your e-mail address and validate your email by clicking on this link.'),
(853, 'en', 22, 'User', 'addEmailAddressEvent', 'message3', 'This e-mail address has been already registered.'),
(854, 'en', 22, 'User', 'addEmailAddressEvent', 'message4', 'Creating unique verifying code failed. Please try again.'),
(855, 'en', 22, 'User', 'addEmailAddressEvent', 'title', 'Add a New Email Address for My Account'),
(856, 'en', 21, 'User', 'addPostalAddressEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(857, 'en', 21, 'User', 'addPostalAddressEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(858, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/addressLine1', 'Street, house number or name, flat number (if any).'),
(859, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/addressLine2', 'City or town or village or other similar administrative division.'),
(860, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/addressLine3', 'County.'),
(861, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/addressLine4', 'State or province or other similar administrative region. If there was no option for your country in drop-down menu and you chose there last option \"other\", then please write your country here.'),
(862, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/comment', 'Any additional comment, which you wish to submit.'),
(863, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/country', 'If your country is not in the list, then please choose the closest country (or last option Other) and describe your country name in comment field.'),
(864, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/postalAddress', 'Whole postal address as it appears on official letters in your country. Your local official address format.'),
(865, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/postCode', 'Postal code or zip code or other similar code.'),
(866, 'en', 21, 'User', 'addPostalAddressEvent', 'guide/title', 'Unique (human readable) title to distinguish postal addresses from one another.'),
(867, 'en', 21, 'User', 'addPostalAddressEvent', 'label/addressLine1', 'Street, house, flat:'),
(868, 'en', 21, 'User', 'addPostalAddressEvent', 'label/addressLine2', 'City / Town / Village:'),
(869, 'en', 21, 'User', 'addPostalAddressEvent', 'label/addressLine3', 'County:'),
(870, 'en', 21, 'User', 'addPostalAddressEvent', 'label/addressLine4', 'State / Province / Region:'),
(871, 'en', 21, 'User', 'addPostalAddressEvent', 'label/comment', 'Comment:'),
(872, 'en', 21, 'User', 'addPostalAddressEvent', 'label/country', 'Country*:'),
(873, 'en', 21, 'User', 'addPostalAddressEvent', 'label/postalAddress', 'Postal address*:'),
(874, 'en', 21, 'User', 'addPostalAddressEvent', 'label/postCode', 'Postal code:'),
(875, 'en', 21, 'User', 'addPostalAddressEvent', 'label/title', 'Postal address title:'),
(876, 'en', 21, 'User', 'addPostalAddressEvent', 'value/save', 'Save'),
(877, 'en', 22, 'User', 'addPostalAddressEvent', 'link1', 'Show list of my postal addresses!'),
(878, 'en', 22, 'User', 'addPostalAddressEvent', 'title', 'Add a New Postal Address for My Account'),
(879, 'en', 11, 'User', 'buildUserBlock:loginAction', 'loginValue', 'Log in'),
(880, 'en', 11, 'User', 'buildUserBlock:loginAction', 'message1', 'User was authenticated.'),
(881, 'en', 11, 'User', 'buildUserBlock:loginAction', 'message2', 'Username and/or password is not correct.'),
(882, 'en', 11, 'User', 'buildUserBlock:loginForm', 'blockTitle', 'Log in / register'),
(883, 'en', 11, 'User', 'buildUserBlock:loginForm', 'loginValue', 'Log in'),
(884, 'en', 11, 'User', 'buildUserBlock:loginForm', 'passwordLabel', 'Password:'),
(885, 'en', 11, 'User', 'buildUserBlock:loginForm', 'recoveryLink', 'Get new password >'),
(886, 'en', 11, 'User', 'buildUserBlock:loginForm', 'recoveryText', 'Forgot password?'),
(887, 'en', 11, 'User', 'buildUserBlock:loginForm', 'registerLink', 'Register >'),
(888, 'en', 11, 'User', 'buildUserBlock:loginForm', 'registerText', ''),
(889, 'en', 11, 'User', 'buildUserBlock:loginForm', 'usernameLabel', 'Username:'),
(890, 'en', 11, 'User', 'buildUserBlock:loginForm', 'verifyLink', 'Verify email >'),
(891, 'en', 11, 'User', 'buildUserBlock:loginForm', 'verifyText', 'Still can not log in?'),
(892, 'en', 11, 'User', 'buildUserBlock:loginLink', 'loginValue', 'Log in'),
(893, 'en', 11, 'User', 'buildUserBlock:logoutLink', 'logoutLabel', 'User:'),
(894, 'en', 11, 'User', 'buildUserBlock:logoutLink', 'logoutValue', 'Log out'),
(895, 'en', 21, 'User', 'changeUserStatusEvent', 'guide/userStatus', 'Change user status. Possible values are active or passive. Passive means that user can not log in.'),
(896, 'en', 21, 'User', 'changeUserStatusEvent', 'label/userStatus', 'User status:'),
(897, 'en', 21, 'User', 'changeUserStatusEvent', 'value/save', 'Save change'),
(898, 'en', 22, 'User', 'changeUserStatusEvent', 'label1', 'Username:'),
(899, 'en', 22, 'User', 'changeUserStatusEvent', 'link1', 'Show accounts'),
(900, 'en', 22, 'User', 'changeUserStatusEvent', 'message1', 'User status was changed.'),
(901, 'en', 22, 'User', 'changeUserStatusEvent', 'message2', 'User id is not correct.'),
(902, 'en', 22, 'User', 'changeUserStatusEvent', 'statusOption1', 'Passive'),
(903, 'en', 22, 'User', 'changeUserStatusEvent', 'statusOption2', 'Active'),
(904, 'en', 22, 'User', 'changeUserStatusEvent', 'title', 'Change User Status'),
(905, 'en', 21, 'User', 'contactFormEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(906, 'en', 21, 'User', 'contactFormEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(907, 'en', 21, 'User', 'contactFormEvent', 'guide/message', ''),
(908, 'en', 21, 'User', 'contactFormEvent', 'guide/senderEmail', ''),
(909, 'en', 21, 'User', 'contactFormEvent', 'guide/senderName', ''),
(910, 'en', 21, 'User', 'contactFormEvent', 'guide/subject', ''),
(911, 'en', 21, 'User', 'contactFormEvent', 'label/message', 'Message:'),
(912, 'en', 21, 'User', 'contactFormEvent', 'label/senderEmail', 'Your e-mail:'),
(913, 'en', 21, 'User', 'contactFormEvent', 'label/senderName', 'Your name:'),
(914, 'en', 21, 'User', 'contactFormEvent', 'label/subject', 'Subject:'),
(915, 'en', 21, 'User', 'contactFormEvent', 'value/send', 'Send'),
(916, 'en', 22, 'User', 'contactFormEvent', 'recipient', 'Message recipient:'),
(917, 'en', 22, 'User', 'contactFormEvent', 'title', 'Contact Form'),
(918, 'en', 22, 'User', 'contactFormEvent', 'captchaNewCode', 'Get another code'),
(919, 'en', 22, 'User', 'contactFormEvent', 'captchaBoxLabel', 'Type the characters in the image'),
(920, 'en', 22, 'User', 'contactFormEvent', 'message1', 'Contact form id is not correct!'),
(921, 'en', 22, 'User', 'contactFormEvent', 'message2', 'Captcha code is not correct.'),
(922, 'en', 22, 'User', 'deleteAccountEvent', 'afterMessage', 'Your user account was deleted.'),
(923, 'en', 22, 'User', 'deleteAccountEvent', 'beforeField1', 'username is'),
(924, 'en', 22, 'User', 'deleteAccountEvent', 'beforeField2', 'main email address is'),
(925, 'en', 22, 'User', 'deleteAccountEvent', 'beforeMessage', 'Are you sure that you want to delete user account, which'),
(926, 'en', 22, 'User', 'deleteAccountEvent', 'link1', 'Show list of user accounts!'),
(927, 'en', 22, 'User', 'deleteAccountEvent', 'message1', 'User id is not correct.'),
(928, 'en', 22, 'User', 'deleteAccountEvent', 'message2', 'You are trying to delete an user account, which does not exist or which you can not delete.'),
(929, 'en', 22, 'User', 'deleteAccountEvent', 'submitYes', 'Yes'),
(930, 'en', 22, 'User', 'deleteAccountEvent', 'title', 'Delete an User Account'),
(931, 'en', 21, 'User', 'deleteAnyAccountEvent', 'guide/delMethod', 'Choose in what way to delete the user account. If deleting \"All user data\" and there are for example pages created or edited by this user, then such pages will not be available any more. If you use \"Leave reference\", then such related data remains available, but instead of showing username by such data, it will be shown \"Deleted user ...\". Username, password, postal addresses, email addresses, contact forms, sent messages will be deleted.'),
(932, 'en', 21, 'User', 'deleteAnyAccountEvent', 'label/delMethod', 'Deleting method:'),
(933, 'en', 22, 'User', 'deleteAnyAccountEvent', 'delOption0', 'Leave reference'),
(934, 'en', 22, 'User', 'deleteAnyAccountEvent', 'delOption1', 'All user data'),
(935, 'en', 22, 'User', 'deleteAnyAccountEvent', 'afterField1', 'username'),
(936, 'en', 22, 'User', 'deleteAnyAccountEvent', 'afterField2', 'main email address'),
(937, 'en', 22, 'User', 'deleteAnyAccountEvent', 'afterMessage', 'The user account with following details was deleted'),
(938, 'en', 22, 'User', 'deleteAnyAccountEvent', 'beforeField1', 'username is'),
(939, 'en', 22, 'User', 'deleteAnyAccountEvent', 'beforeField2', 'main email address is'),
(940, 'en', 22, 'User', 'deleteAnyAccountEvent', 'beforeMessage', 'Are you sure that you want to delete user account, which'),
(941, 'en', 22, 'User', 'deleteAnyAccountEvent', 'link1', 'Show list of user accounts!'),
(942, 'en', 22, 'User', 'deleteAnyAccountEvent', 'message1', 'User id is not correct.'),
(943, 'en', 22, 'User', 'deleteAnyAccountEvent', 'submitYes', 'Yes'),
(944, 'en', 22, 'User', 'deleteAnyAccountEvent', 'title', 'Delete an User Account'),
(945, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'beforeField2', 'email address is'),
(946, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'beforeMessage', 'Are you sure that you want to delete the contact form, which'),
(947, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'link1', 'Show list of all contact forms!'),
(948, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'message1', 'Contact form id is not correct.'),
(949, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'message2', 'A contact form with such id does not exist or this id is not referring to your contact form.'),
(950, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'afterField1', 'contact name'),
(951, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'afterField2', 'email address'),
(952, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'afterMessage', 'The contact form with following details was deleted'),
(953, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'beforeField1', 'contact name is'),
(954, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'submitYes', 'Yes'),
(955, 'en', 22, 'User', 'deleteAnyContactFormEvent', 'title', 'Delete a Contact Form'),
(956, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'afterField1', 'username'),
(957, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'afterField2', 'email address'),
(958, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'afterMessage', 'The email address with following details was deleted'),
(959, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'beforeField1', 'username is'),
(960, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'beforeField2', 'email address is'),
(961, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'beforeMessage', 'Are you sure that you want to delete the email address, which'),
(962, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'link1', 'Show list of my all email addresses!'),
(963, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'message1', 'Email address id is not correct.'),
(964, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'message2', 'An email address with such id does not exist or this id is not referring to your email address.'),
(965, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'message3', 'This email address can not be deleted, because it has contact forms related to it.'),
(966, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'message4', 'This is main email address and you can not delete it.'),
(967, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'submitYes', 'Yes'),
(968, 'en', 22, 'User', 'deleteAnyEmailAddressEvent', 'title', 'Delete an Email Address'),
(969, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'afterField1', 'title'),
(970, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'afterField2', 'comment'),
(971, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'afterField3', ''),
(972, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'afterMessage', 'The postal address with following details was deleted'),
(973, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'beforeField1', 'title is'),
(974, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'beforeField2', 'comment is'),
(975, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'beforeField3', ''),
(976, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'beforeMessage', 'Are you sure that you want to delete the postal address, which'),
(977, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'link1', 'Show list of all postal addresses!'),
(978, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'message1', 'Postal address id is not correct.'),
(979, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'message2', 'A postal address with such id does not exist or this id is not referring to your postal address.'),
(980, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'submitYes', 'Yes'),
(981, 'en', 22, 'User', 'deleteAnyPostalAddressEvent', 'title', 'Delete a Postal Address'),
(982, 'en', 22, 'User', 'deleteContactFormEvent', 'afterMessage', 'The contact form with following details was deleted'),
(983, 'en', 22, 'User', 'deleteContactFormEvent', 'beforeField1', 'contact name is'),
(984, 'en', 22, 'User', 'deleteContactFormEvent', 'beforeField2', 'email address is'),
(985, 'en', 22, 'User', 'deleteContactFormEvent', 'beforeMessage', 'Are you sure that you want to delete the contact form, which'),
(986, 'en', 22, 'User', 'deleteContactFormEvent', 'message1', 'Contact form id is not correct.'),
(987, 'en', 22, 'User', 'deleteContactFormEvent', 'message2', 'A contact form with such id does not exist or this id is not referring to your contact form.'),
(988, 'en', 22, 'User', 'deleteContactFormEvent', 'submitYes', 'Yes'),
(989, 'en', 22, 'User', 'deleteContactFormEvent', 'title', 'Delete My Contact Form'),
(990, 'en', 22, 'User', 'deleteContactFormEvent', 'afterField1', 'contact name'),
(991, 'en', 22, 'User', 'deleteContactFormEvent', 'afterField2', 'email address'),
(992, 'en', 22, 'User', 'deleteContactFormEvent', 'link1', 'Show list of my contact forms!'),
(993, 'en', 22, 'User', 'deleteEmailAddressEvent', 'afterField1', 'username'),
(994, 'en', 22, 'User', 'deleteEmailAddressEvent', 'afterField2', 'email address'),
(995, 'en', 22, 'User', 'deleteEmailAddressEvent', 'afterMessage', 'The email address with following details was deleted'),
(996, 'en', 22, 'User', 'deleteEmailAddressEvent', 'beforeField1', 'username is'),
(997, 'en', 22, 'User', 'deleteEmailAddressEvent', 'beforeField2', 'email address is'),
(998, 'en', 22, 'User', 'deleteEmailAddressEvent', 'beforeMessage', 'Are you sure that you want to delete the email address, which'),
(999, 'en', 22, 'User', 'deleteEmailAddressEvent', 'link1', 'Show list of my email addresses!'),
(1000, 'en', 22, 'User', 'deleteEmailAddressEvent', 'message1', 'Email address id is not correct.'),
(1001, 'en', 22, 'User', 'deleteEmailAddressEvent', 'message2', 'An email address with such id does not exist or this id is not referring to your email address.'),
(1002, 'en', 22, 'User', 'deleteEmailAddressEvent', 'message3', 'This email address can not be deleted, because it has contact forms related to it.'),
(1003, 'en', 22, 'User', 'deleteEmailAddressEvent', 'message4', 'This is main email address and you can not delete it.'),
(1004, 'en', 22, 'User', 'deleteEmailAddressEvent', 'submitYes', 'Yes'),
(1005, 'en', 22, 'User', 'deleteEmailAddressEvent', 'title', 'Delete My Email Address'),
(1006, 'en', 22, 'User', 'deletePostalAddressEvent', 'afterField1', 'title'),
(1007, 'en', 22, 'User', 'deletePostalAddressEvent', 'afterField2', 'comment'),
(1008, 'en', 22, 'User', 'deletePostalAddressEvent', 'afterField3', ''),
(1009, 'en', 22, 'User', 'deletePostalAddressEvent', 'afterMessage', 'The postal address with following details was deleted'),
(1010, 'en', 22, 'User', 'deletePostalAddressEvent', 'beforeField1', 'title is'),
(1011, 'en', 22, 'User', 'deletePostalAddressEvent', 'beforeField2', 'comment is'),
(1012, 'en', 22, 'User', 'deletePostalAddressEvent', 'beforeField3', ''),
(1013, 'en', 22, 'User', 'deletePostalAddressEvent', 'beforeMessage', 'Are you sure that you want to delete the postal address, which'),
(1014, 'en', 22, 'User', 'deletePostalAddressEvent', 'link1', 'Show list of my postal addresses!'),
(1015, 'en', 22, 'User', 'deletePostalAddressEvent', 'message1', 'Postal address id is not correct.'),
(1016, 'en', 22, 'User', 'deletePostalAddressEvent', 'message2', 'A postal address with such id does not exist or this id is not referring to your postal address.'),
(1017, 'en', 22, 'User', 'deletePostalAddressEvent', 'submitYes', 'Yes'),
(1018, 'en', 22, 'User', 'deletePostalAddressEvent', 'title', 'Delete My Postal Address'),
(1019, 'en', 21, 'User', 'editAccountEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1020, 'en', 21, 'User', 'editAccountEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1021, 'en', 21, 'User', 'editAccountEvent', 'guide/company', ''),
(1022, 'en', 21, 'User', 'editAccountEvent', 'guide/emailId', 'Choose your verified main email address.'),
(1023, 'en', 21, 'User', 'editAccountEvent', 'guide/firstName', 'First name (forename, first given name). Please double check the first name and fill middle names field (if any) at the same time. If this field is filled, then it can not be edited later.'),
(1024, 'en', 21, 'User', 'editAccountEvent', 'guide/lastName', 'Last name (surname). Please double check the last name. If this field is filled, then it can not be edited later.'),
(1025, 'en', 21, 'User', 'editAccountEvent', 'guide/middleNames', 'Middle names (other given names, if any; separated by commas). Please double check the middle names and fill first name field at the same time. If this field is filled, then it can not be edited later.'),
(1026, 'en', 21, 'User', 'editAccountEvent', 'guide/password', ''),
(1027, 'en', 21, 'User', 'editAccountEvent', 'guide/password2', 'Type your password again.'),
(1028, 'en', 21, 'User', 'editAccountEvent', 'guide/passwordStatus', 'Whether to change password too or leave it unchanged.'),
(1029, 'en', 21, 'User', 'editAccountEvent', 'guide/phone1', 'Mobile or landline phone number.'),
(1030, 'en', 21, 'User', 'editAccountEvent', 'guide/phone2', 'Another mobile or landline phone number.'),
(1031, 'en', 21, 'User', 'editAccountEvent', 'guide/username', ''),
(1032, 'en', 21, 'User', 'editAccountEvent', 'label/company', 'Company:'),
(1033, 'en', 21, 'User', 'editAccountEvent', 'label/emailId', 'Main email:'),
(1034, 'en', 21, 'User', 'editAccountEvent', 'label/firstName', 'First name:'),
(1035, 'en', 21, 'User', 'editAccountEvent', 'label/lastName', 'Last name:'),
(1036, 'en', 21, 'User', 'editAccountEvent', 'label/middleNames', 'Middle names:'),
(1037, 'en', 21, 'User', 'editAccountEvent', 'label/password', 'Password:'),
(1038, 'en', 21, 'User', 'editAccountEvent', 'label/password2', 'Repeat password:'),
(1039, 'en', 21, 'User', 'editAccountEvent', 'label/passwordStatus', 'Password change status:'),
(1040, 'en', 21, 'User', 'editAccountEvent', 'label/phone1', 'Phone:'),
(1041, 'en', 21, 'User', 'editAccountEvent', 'label/phone2', 'Second phone:'),
(1042, 'en', 21, 'User', 'editAccountEvent', 'label/username', 'Username:'),
(1043, 'en', 21, 'User', 'editAccountEvent', 'value/save', 'Save'),
(1044, 'en', 22, 'User', 'editAccountEvent', 'statusOption0', 'No change'),
(1045, 'en', 22, 'User', 'editAccountEvent', 'statusOption1', 'Change password'),
(1046, 'en', 22, 'User', 'editAccountEvent', 'link1', 'Show my account options!'),
(1047, 'en', 22, 'User', 'editAccountEvent', 'message1', 'User id is not correct.'),
(1048, 'en', 22, 'User', 'editAccountEvent', 'message2', 'An user with such id does not exist or this id is not referring to your user.'),
(1049, 'en', 22, 'User', 'editAccountEvent', 'message3', 'Password is not set or does not match with repeated password.'),
(1050, 'en', 22, 'User', 'editAccountEvent', 'title', 'Edit My Account Details'),
(1051, 'en', 21, 'User', 'editAnyAccountEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1052, 'en', 21, 'User', 'editAnyAccountEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1053, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/company', ''),
(1054, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/emailId', 'Choose your verified main email address.'),
(1055, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/firstName', 'First name (forename, first given name). Please double check the first name and fill middle names field (if any) at the same time. If this field is filled, then it can not be edited later.'),
(1056, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/lastName', 'Last name (surname). Please double check the last name. If this field is filled, then it can not be edited later.'),
(1057, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/middleNames', 'Middle names (other given names, if any; separated by commas). Please double check the middle names and fill first name field at the same time. If this field is filled, then it can not be edited later.'),
(1058, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/password', ''),
(1059, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/password2', 'Type your password again.'),
(1060, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/passwordStatus', 'Whether to change password too or leave it unchanged.');
INSERT INTO `core_language` (`id`, `language_code`, `type`, `module_name`, `specific_name`, `uri`, `text`) VALUES
(1061, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/phone1', 'Mobile or landline phone number.'),
(1062, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/phone2', 'Another mobile or landline phone number.'),
(1063, 'en', 21, 'User', 'editAnyAccountEvent', 'guide/username', ''),
(1064, 'en', 21, 'User', 'editAnyAccountEvent', 'label/company', 'Company:'),
(1065, 'en', 21, 'User', 'editAnyAccountEvent', 'label/emailId', 'Main email:'),
(1066, 'en', 21, 'User', 'editAnyAccountEvent', 'label/firstName', 'First name*:'),
(1067, 'en', 21, 'User', 'editAnyAccountEvent', 'label/lastName', 'Last name*:'),
(1068, 'en', 21, 'User', 'editAnyAccountEvent', 'label/middleNames', 'Middle names:'),
(1069, 'en', 21, 'User', 'editAnyAccountEvent', 'label/password', 'Password:'),
(1070, 'en', 21, 'User', 'editAnyAccountEvent', 'label/password2', 'Repeat password:'),
(1071, 'en', 21, 'User', 'editAnyAccountEvent', 'label/passwordStatus', 'Password change status:'),
(1072, 'en', 21, 'User', 'editAnyAccountEvent', 'label/phone1', 'Phone:'),
(1073, 'en', 21, 'User', 'editAnyAccountEvent', 'label/phone2', 'Second phone:'),
(1074, 'en', 21, 'User', 'editAnyAccountEvent', 'label/username', 'Username:'),
(1075, 'en', 21, 'User', 'editAnyAccountEvent', 'value/save', 'Save'),
(1076, 'en', 22, 'User', 'editAnyAccountEvent', 'link1', 'List accounts!'),
(1077, 'en', 22, 'User', 'editAnyAccountEvent', 'message1', 'User id is not correct.'),
(1078, 'en', 22, 'User', 'editAnyAccountEvent', 'statusOption0', 'No change'),
(1079, 'en', 22, 'User', 'editAnyAccountEvent', 'statusOption1', 'Change password'),
(1080, 'en', 22, 'User', 'editAnyAccountEvent', 'message2', 'This user account can not be edited because this user does not have any verified or accepted email address.'),
(1081, 'en', 22, 'User', 'editAnyAccountEvent', 'title', 'Edit Any Account Details'),
(1082, 'en', 21, 'User', 'editAnyContactFormEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1083, 'en', 21, 'User', 'editAnyContactFormEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1084, 'en', 21, 'User', 'editAnyContactFormEvent', 'guide/contactName', ''),
(1085, 'en', 21, 'User', 'editAnyContactFormEvent', 'guide/description', ''),
(1086, 'en', 21, 'User', 'editAnyContactFormEvent', 'guide/emailId', 'Choose your verified email address, where the messages of this contact forms will be sent to.'),
(1087, 'en', 21, 'User', 'editAnyContactFormEvent', 'guide/status', 'Active is meaning, that the form can be used by other people; passive is meaning that it can not be used.'),
(1088, 'en', 21, 'User', 'editAnyContactFormEvent', 'label/contactName', 'Contact name:'),
(1089, 'en', 21, 'User', 'editAnyContactFormEvent', 'label/description', 'Contact form description:'),
(1090, 'en', 21, 'User', 'editAnyContactFormEvent', 'label/emailId', 'Email:'),
(1091, 'en', 21, 'User', 'editAnyContactFormEvent', 'label/status', 'Contact status:'),
(1092, 'en', 21, 'User', 'editAnyContactFormEvent', 'value/save', 'Save'),
(1093, 'en', 22, 'User', 'editAnyContactFormEvent', 'message2', 'A contact form with such id does not exist or this id is not referring to your contact form.'),
(1094, 'en', 22, 'User', 'editAnyContactFormEvent', 'statusOption0', 'Passive'),
(1095, 'en', 22, 'User', 'editAnyContactFormEvent', 'statusOption1', 'Active'),
(1096, 'en', 22, 'User', 'editAnyContactFormEvent', 'link1', 'List all contact forms!'),
(1097, 'en', 22, 'User', 'editAnyContactFormEvent', 'message1', 'Contact form id is not correct.'),
(1099, 'en', 22, 'User', 'editAnyContactFormEvent', 'title', 'Edit Any Existing Contact Form'),
(1100, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1101, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1102, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'guide/comment', 'Any comment, which you wish to add.'),
(1103, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'guide/memWord', 'If you see the form field Memorable word, then this means, that your e-mail address is related to such word and you must submit both (your email address and such a word) to ask for a new password and username.'),
(1104, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'guide/memWordQuestion', 'Question to remind the memorable word.'),
(1105, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'label/comment', 'Comment:'),
(1106, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'label/emailAddress', 'Email address:'),
(1107, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'label/memWord', 'Memorable word:'),
(1108, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'label/memWordQuestion', 'Memorable word question:'),
(1109, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'label/status', 'Email status:'),
(1110, 'en', 21, 'User', 'editAnyEmailAddressEvent', 'value/save', 'Save'),
(1112, 'en', 22, 'User', 'editAnyEmailAddressEvent', 'link1', 'Show list of all email addresses!'),
(1114, 'en', 22, 'User', 'editAnyEmailAddressEvent', 'message1', 'Email address id is not correct.'),
(1116, 'en', 22, 'User', 'editAnyEmailAddressEvent', 'message2', 'Email status:'),
(1117, 'en', 22, 'User', 'editAnyEmailAddressEvent', 'message3', '. This email address has contact forms related to it and because of this the email status can not be changed and the email must be verified.'),
(1118, 'en', 22, 'User', 'editAnyEmailAddressEvent', 'statusOption0', 'Created'),
(1119, 'en', 22, 'User', 'editAnyEmailAddressEvent', 'statusOption1', 'Verified'),
(1120, 'en', 22, 'User', 'editAnyEmailAddressEvent', 'statusOption2', 'Created recently'),
(1121, 'en', 22, 'User', 'editAnyEmailAddressEvent', 'title', 'Edit an Existing Email Address'),
(1122, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1123, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1124, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/addressLine1', 'Street, house number or name, flat number (if any).'),
(1125, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/addressLine2', 'City or town or village or other similar administrative division.'),
(1126, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/addressLine3', 'County.'),
(1127, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/addressLine4', 'State or province or other similar administrative region. If there was no option for your country in drop-down menu and you chose there last option \"other\", then please write your country here.'),
(1128, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/comment', 'Any additional comment, which you wish to submit.'),
(1129, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/country', 'If your country is not in the list, then please choose the closest country (or last option Other) and describe your country name in comment field.'),
(1130, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/postalAddress', 'Whole postal address as it appears on official letters in your country. Your local official address format.'),
(1131, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/postCode', 'Postal code or zip code or other similar code.'),
(1132, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'guide/title', 'Unique (human readable) title to distinguish postal addresses from one another.'),
(1133, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/addressLine1', 'Street, house, flat:'),
(1134, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/addressLine2', 'City / Town / Village:'),
(1135, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/addressLine3', 'County:'),
(1136, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/addressLine4', 'State / Province / Region:'),
(1137, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/comment', 'Comment:'),
(1138, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/country', 'Country*:'),
(1139, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/postalAddress', 'Postal address*:'),
(1140, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/postCode', 'Postal code:'),
(1141, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'label/title', 'Postal address title:'),
(1142, 'en', 21, 'User', 'editAnyPostalAddressEvent', 'value/save', 'Save'),
(1143, 'en', 22, 'User', 'editAnyPostalAddressEvent', 'link1', 'Show list of all postal addresses!'),
(1144, 'en', 22, 'User', 'editAnyPostalAddressEvent', 'message1', 'Postal address id is not correct.'),
(1145, 'en', 22, 'User', 'editAnyPostalAddressEvent', 'title', 'Edit an Exiting Postal Address'),
(1146, 'en', 21, 'User', 'editContactFormEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1147, 'en', 21, 'User', 'editContactFormEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1148, 'en', 21, 'User', 'editContactFormEvent', 'guide/contactName', ''),
(1149, 'en', 21, 'User', 'editContactFormEvent', 'guide/description', ''),
(1150, 'en', 21, 'User', 'editContactFormEvent', 'guide/emailId', 'Choose your verified email address, where the messages of this contact forms will be sent to.'),
(1151, 'en', 21, 'User', 'editContactFormEvent', 'guide/status', 'Active is meaning, that the form can be used by other people; passive is meaning that it can not be used.'),
(1152, 'en', 21, 'User', 'editContactFormEvent', 'label/contactName', 'Contact name:'),
(1153, 'en', 21, 'User', 'editContactFormEvent', 'label/description', 'Contact form description:'),
(1154, 'en', 21, 'User', 'editContactFormEvent', 'label/emailId', 'Email:'),
(1155, 'en', 21, 'User', 'editContactFormEvent', 'label/status', 'Contact status:'),
(1156, 'en', 21, 'User', 'editContactFormEvent', 'value/save', 'Save'),
(1157, 'en', 22, 'User', 'editContactFormEvent', 'message2', 'A contact form with such id does not exist or this id is not referring to your contact form.'),
(1158, 'en', 22, 'User', 'editContactFormEvent', 'statusOption0', 'Passive'),
(1159, 'en', 22, 'User', 'editContactFormEvent', 'statusOption1', 'Active'),
(1160, 'en', 22, 'User', 'editContactFormEvent', 'title', 'Edit an Existing Contact Form of My Account'),
(1161, 'en', 22, 'User', 'editContactFormEvent', 'link1', 'Show list of my contact forms!'),
(1162, 'en', 22, 'User', 'editContactFormEvent', 'message1', 'Contact form id is not correct.'),
(1163, 'en', 21, 'User', 'editEmailAddressEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1164, 'en', 21, 'User', 'editEmailAddressEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1165, 'en', 21, 'User', 'editEmailAddressEvent', 'guide/comment', 'Any comment, which you wish to add.'),
(1166, 'en', 21, 'User', 'editEmailAddressEvent', 'guide/memWord', 'If you see the form field Memorable word, then this means, that your e-mail address is related to such word and you must submit both (your email address and such a word) to ask for a new password and username.'),
(1167, 'en', 21, 'User', 'editEmailAddressEvent', 'guide/memWordQuestion', 'Question to remind the memorable word.'),
(1168, 'en', 21, 'User', 'editEmailAddressEvent', 'label/comment', 'Comment:'),
(1169, 'en', 21, 'User', 'editEmailAddressEvent', 'label/emailAddress', 'Email address:'),
(1170, 'en', 21, 'User', 'editEmailAddressEvent', 'label/memWord', 'Memorable word:'),
(1171, 'en', 21, 'User', 'editEmailAddressEvent', 'label/memWordQuestion', 'Memorable word question:'),
(1172, 'en', 21, 'User', 'editEmailAddressEvent', 'label/status', 'Email status:'),
(1173, 'en', 21, 'User', 'editEmailAddressEvent', 'value/save', 'Save'),
(1174, 'en', 22, 'User', 'editEmailAddressEvent', 'link1', 'Show list of my email addresses!'),
(1175, 'en', 22, 'User', 'editEmailAddressEvent', 'message1', 'Email address id is not correct.'),
(1176, 'en', 22, 'User', 'editEmailAddressEvent', 'message2', 'An email address with such id does not exist or this id is not referring to your email address.'),
(1177, 'en', 22, 'User', 'editEmailAddressEvent', 'statusOption0', 'Created'),
(1178, 'en', 22, 'User', 'editEmailAddressEvent', 'statusOption1', 'Verified'),
(1179, 'en', 22, 'User', 'editEmailAddressEvent', 'statusOption2', 'Created recently'),
(1180, 'en', 22, 'User', 'editEmailAddressEvent', 'title', 'Edit an Existing Email Address of My Account'),
(1181, 'en', 21, 'User', 'editPostalAddressEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1182, 'en', 21, 'User', 'editPostalAddressEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1183, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/addressLine1', 'Street, house number or name, flat number (if any).'),
(1184, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/addressLine2', 'City or town or village or other similar administrative division.'),
(1185, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/addressLine3', 'County.'),
(1186, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/addressLine4', 'State or province or other similar administrative region. If there was no option for your country in drop-down menu and you chose there last option \"other\", then please write your country here.'),
(1187, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/comment', 'Any additional comment, which you wish to submit.'),
(1188, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/country', 'If your country is not in the list, then please choose the closest country (or last option Other) and describe your country name in comment field.'),
(1189, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/postalAddress', 'Whole postal address as it appears on official letters in your country. Your local official address format.'),
(1190, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/postCode', 'Postal code or zip code or other similar code.'),
(1191, 'en', 21, 'User', 'editPostalAddressEvent', 'guide/title', 'Unique (human readable) title to distinguish postal addresses from one another.'),
(1192, 'en', 21, 'User', 'editPostalAddressEvent', 'label/addressLine1', 'Street, house, flat:'),
(1193, 'en', 21, 'User', 'editPostalAddressEvent', 'label/addressLine2', 'City / Town / Village:'),
(1194, 'en', 21, 'User', 'editPostalAddressEvent', 'label/addressLine3', 'County:'),
(1195, 'en', 21, 'User', 'editPostalAddressEvent', 'label/addressLine4', 'State / Province / Region:'),
(1196, 'en', 21, 'User', 'editPostalAddressEvent', 'label/comment', 'Comment:'),
(1197, 'en', 21, 'User', 'editPostalAddressEvent', 'label/country', 'Country*:'),
(1198, 'en', 21, 'User', 'editPostalAddressEvent', 'label/postalAddress', 'Postal address*:'),
(1199, 'en', 21, 'User', 'editPostalAddressEvent', 'label/postCode', 'Postal code:'),
(1200, 'en', 21, 'User', 'editPostalAddressEvent', 'label/title', 'Postal address title:'),
(1201, 'en', 21, 'User', 'editPostalAddressEvent', 'value/save', 'Save'),
(1202, 'en', 22, 'User', 'editPostalAddressEvent', 'link1', 'Show list of my postal addresses!'),
(1203, 'en', 22, 'User', 'editPostalAddressEvent', 'message1', 'Postal address id is not correct.'),
(1204, 'en', 22, 'User', 'editPostalAddressEvent', 'message2', 'A postal address with such id does not exist or this id is not referring to your postal address.'),
(1205, 'en', 22, 'User', 'editPostalAddressEvent', 'title', 'Edit an Existing Postal Address of My Account'),
(1206, 'en', 21, 'User', 'indexEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1207, 'en', 21, 'User', 'indexEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1208, 'en', 21, 'User', 'indexEvent', 'label/password', 'Password*:'),
(1209, 'en', 21, 'User', 'indexEvent', 'label/username', 'Username*:'),
(1210, 'en', 21, 'User', 'indexEvent', 'value/login', 'Login'),
(1211, 'en', 21, 'User', 'indexEvent', 'value/logout', 'Logout'),
(1212, 'en', 22, 'User', 'indexEvent', 'message1', 'User was authenticated.'),
(1213, 'en', 22, 'User', 'indexEvent', 'message2', 'Username and/or password is not correct.'),
(1214, 'en', 22, 'User', 'indexEvent', 'message3', 'User was logged out.'),
(1215, 'en', 22, 'User', 'indexEvent', 'label1', 'User:'),
(1216, 'en', 22, 'User', 'indexEvent', 'recoveryLink', 'Request new password »'),
(1217, 'en', 22, 'User', 'indexEvent', 'recoveryText', 'Forgot password?'),
(1218, 'en', 22, 'User', 'indexEvent', 'registerLink', 'Not user yet, Register'),
(1219, 'en', 22, 'User', 'indexEvent', 'registerText', ''),
(1220, 'en', 22, 'User', 'listAccountsEvent', 'entriesCount', 'Total entries found: [allEntries].'),
(1221, 'en', 22, 'User', 'listAccountsEvent', 'paginStatus', 'Current search result page: [curPage] of [allPages].'),
(1222, 'en', 22, 'User', 'listAccountsEvent', 'statusOption1', 'Passive'),
(1223, 'en', 22, 'User', 'listAccountsEvent', 'statusOption2', 'Active'),
(1224, 'en', 22, 'User', 'listAccountsEvent', 'link1', 'Add an user (account)'),
(1225, 'en', 22, 'User', 'listAccountsEvent', 'link2', 'Edit'),
(1226, 'en', 22, 'User', 'listAccountsEvent', 'link3', 'Delete'),
(1227, 'en', 22, 'User', 'listAccountsEvent', 'link4', 'Change status'),
(1228, 'en', 22, 'User', 'listAccountsEvent', 'message1', 'There are no user accounts.'),
(1229, 'en', 22, 'User', 'listAccountsEvent', 'tb1ColEmail', 'Email address'),
(1230, 'en', 22, 'User', 'listAccountsEvent', 'tb1ColStatus', 'User status'),
(1231, 'en', 22, 'User', 'listAccountsEvent', 'tb1ColUsername', 'Username'),
(1232, 'en', 22, 'User', 'listAccountsEvent', 'tb1Title', ''),
(1233, 'en', 22, 'User', 'listAccountsEvent', 'title', 'List of All User Accounts'),
(1234, 'en', 22, 'User', 'listAllContactFormsEvent', 'entriesCount', 'Total entries found: [allEntries].'),
(1235, 'en', 22, 'User', 'listAllContactFormsEvent', 'link4', 'Contact form'),
(1236, 'en', 22, 'User', 'listAllContactFormsEvent', 'message1', 'There are no contact forms.'),
(1237, 'en', 22, 'User', 'listAllContactFormsEvent', 'paginStatus', 'Current search result page: [curPage] of [allPages].'),
(1238, 'en', 22, 'User', 'listAllContactFormsEvent', 'statusOption0', 'Passive'),
(1239, 'en', 22, 'User', 'listAllContactFormsEvent', 'statusOption1', 'Active'),
(1240, 'en', 22, 'User', 'listAllContactFormsEvent', 'tb1ColDescription', 'Description'),
(1241, 'en', 22, 'User', 'listAllContactFormsEvent', 'tb1ColEmail', 'Email address'),
(1242, 'en', 22, 'User', 'listAllContactFormsEvent', 'tb1ColName', 'Contact name'),
(1243, 'en', 22, 'User', 'listAllContactFormsEvent', 'tb1ColStatus', 'Status'),
(1244, 'en', 22, 'User', 'listAllContactFormsEvent', 'tb1ColUsername', 'Username'),
(1245, 'en', 22, 'User', 'listAllContactFormsEvent', 'title', 'List of All Contact Forms'),
(1246, 'en', 22, 'User', 'listAllContactFormsEvent', 'link1', 'Add a contact form'),
(1247, 'en', 22, 'User', 'listAllContactFormsEvent', 'link2', 'Edit'),
(1248, 'en', 22, 'User', 'listAllContactFormsEvent', 'link3', 'Delete'),
(1249, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'entriesCount', 'Total entries found: [allEntries].'),
(1250, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'link1', 'Add an email address'),
(1251, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'link2', 'Edit'),
(1252, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'link3', 'Delete'),
(1253, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'message2', 'Main address:'),
(1254, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'paginStatus', 'Current search result page: [curPage] of [allPages].'),
(1255, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'statusOption0', 'Created'),
(1256, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'statusOption1', 'Verified'),
(1257, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'statusOption2', 'Created recently'),
(1258, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'tb1ColEmail', 'Email address'),
(1259, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'tb1ColQuestion', 'Memorable word question'),
(1260, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'tb1ColStatus', 'Status'),
(1261, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'tb1ColUsername', 'Username'),
(1262, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'title', 'List of All Email Addresses'),
(1263, 'en', 22, 'User', 'listAllEmailAddressesEvent', 'message1', 'There are no email addresses.'),
(1264, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'entriesCount', 'Total entries found: [allEntries].'),
(1265, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'link1', 'Add a postal address'),
(1266, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'link2', 'Edit'),
(1267, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'link3', 'Delete'),
(1268, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'message1', 'There are no postal addresses.'),
(1269, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'paginStatus', 'Current search result page: [curPage] of [allPages].'),
(1270, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'tb1ColAddress', 'Postal address'),
(1271, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'tb1ColComment', 'Comment'),
(1272, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'tb1ColTitle', 'Title'),
(1273, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'tb1ColUsername', 'Username'),
(1274, 'en', 22, 'User', 'listAllPostalAddressesEvent', 'title', 'List of All Postal Addresses'),
(1275, 'en', 22, 'User', 'listContactFormsEvent', 'entriesCount', 'Total entries found: [allEntries].'),
(1276, 'en', 22, 'User', 'listContactFormsEvent', 'link1', 'Add a contact form'),
(1277, 'en', 22, 'User', 'listContactFormsEvent', 'link2', 'Edit'),
(1278, 'en', 22, 'User', 'listContactFormsEvent', 'link3', 'Delete'),
(1279, 'en', 22, 'User', 'listContactFormsEvent', 'message1', 'There are no contact forms.'),
(1280, 'en', 22, 'User', 'listContactFormsEvent', 'paginStatus', 'Current search result page: [curPage] of [allPages].'),
(1281, 'en', 22, 'User', 'listContactFormsEvent', 'statusOption0', 'Passive'),
(1282, 'en', 22, 'User', 'listContactFormsEvent', 'statusOption1', 'Active'),
(1283, 'en', 22, 'User', 'listContactFormsEvent', 'tb1ColDescription', 'Description'),
(1284, 'en', 22, 'User', 'listContactFormsEvent', 'tb1ColEmail', 'Email address'),
(1285, 'en', 22, 'User', 'listContactFormsEvent', 'tb1ColName', 'Contact name'),
(1286, 'en', 22, 'User', 'listContactFormsEvent', 'tb1ColStatus', 'Status'),
(1287, 'en', 22, 'User', 'listContactFormsEvent', 'title', 'List of My Contact Forms'),
(1288, 'en', 22, 'User', 'listEmailAddressesEvent', 'entriesCount', 'Total entries found: [allEntries].'),
(1289, 'en', 22, 'User', 'listEmailAddressesEvent', 'link1', 'Add an email address'),
(1290, 'en', 22, 'User', 'listEmailAddressesEvent', 'link2', 'Edit'),
(1291, 'en', 22, 'User', 'listEmailAddressesEvent', 'link3', 'Delete'),
(1292, 'en', 22, 'User', 'listEmailAddressesEvent', 'message1', 'There are no email addresses.'),
(1293, 'en', 22, 'User', 'listEmailAddressesEvent', 'paginStatus', 'Current search result page: [curPage] of [allPages].'),
(1294, 'en', 22, 'User', 'listEmailAddressesEvent', 'statusOption0', 'Created'),
(1295, 'en', 22, 'User', 'listEmailAddressesEvent', 'statusOption1', 'Verified'),
(1296, 'en', 22, 'User', 'listEmailAddressesEvent', 'statusOption2', 'Created recently'),
(1297, 'en', 22, 'User', 'listEmailAddressesEvent', 'tb1ColEmail', 'Email address'),
(1298, 'en', 22, 'User', 'listEmailAddressesEvent', 'tb1ColQuestion', 'Memorable word question'),
(1299, 'en', 22, 'User', 'listEmailAddressesEvent', 'tb1ColStatus', 'Status'),
(1300, 'en', 22, 'User', 'listEmailAddressesEvent', 'title', 'List of My Email Addresses'),
(1301, 'en', 22, 'User', 'listPostalAddressesEvent', 'entriesCount', 'Total entries found: [allEntries].'),
(1302, 'en', 22, 'User', 'listPostalAddressesEvent', 'link1', 'Add a postal address'),
(1303, 'en', 22, 'User', 'listPostalAddressesEvent', 'link2', 'Edit'),
(1304, 'en', 22, 'User', 'listPostalAddressesEvent', 'link3', 'Delete'),
(1305, 'en', 22, 'User', 'listPostalAddressesEvent', 'message1', 'There are no postal addresses.'),
(1306, 'en', 22, 'User', 'listPostalAddressesEvent', 'paginStatus', 'Current search result page: [curPage] of [allPages].'),
(1307, 'en', 22, 'User', 'listPostalAddressesEvent', 'tb1ColAddress', 'Postal address'),
(1308, 'en', 22, 'User', 'listPostalAddressesEvent', 'tb1ColComment', 'Comment'),
(1309, 'en', 22, 'User', 'listPostalAddressesEvent', 'tb1ColTitle', 'Title'),
(1310, 'en', 22, 'User', 'listPostalAddressesEvent', 'title', 'List of My Postal Addresses'),
(1311, 'en', 21, 'User', 'loginEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1312, 'en', 21, 'User', 'loginEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1313, 'en', 21, 'User', 'loginEvent', 'label/password', 'Password*:'),
(1314, 'en', 21, 'User', 'loginEvent', 'label/username', 'Username*:'),
(1315, 'en', 21, 'User', 'loginEvent', 'value/login', 'Login'),
(1316, 'en', 21, 'User', 'loginEvent', 'value/logout', 'Logout'),
(1317, 'en', 22, 'User', 'loginEvent', 'label1', 'User:'),
(1318, 'en', 22, 'User', 'loginEvent', 'recoveryLink', 'Request new password »'),
(1319, 'en', 22, 'User', 'loginEvent', 'recoveryText', 'Forgot password?'),
(1320, 'en', 22, 'User', 'loginEvent', 'registerLink', 'Sign up »'),
(1321, 'en', 22, 'User', 'loginEvent', 'registerText', 'No account?'),
(1322, 'en', 22, 'User', 'loginEvent', 'message1', 'User was authenticated.'),
(1323, 'en', 22, 'User', 'loginEvent', 'message2', 'Username and/or password is not correct.'),
(1324, 'en', 22, 'User', 'logoutEvent', 'message1', 'User was logged out.'),
(1325, 'en', 22, 'User', 'myAccountOptionsEvent', 'link1', 'Edit my account'),
(1326, 'en', 22, 'User', 'myAccountOptionsEvent', 'link2', 'List of my email addresses'),
(1327, 'en', 22, 'User', 'myAccountOptionsEvent', 'link3', 'List of my contact forms'),
(1328, 'en', 22, 'User', 'myAccountOptionsEvent', 'link4', 'List of my postal addresses'),
(1329, 'en', 22, 'User', 'myAccountOptionsEvent', 'link5', 'Delete my account'),
(1330, 'en', 22, 'User', 'myAccountOptionsEvent', 'message1', 'User id is not correct.'),
(1331, 'en', 22, 'User', 'myAccountOptionsEvent', 'message2', 'An user with such id does not exist or this id is not referring to your user.'),
(1332, 'en', 22, 'User', 'myAccountOptionsEvent', 'title', 'My Account Options'),
(1333, 'en', 21, 'User', 'recoverAccountEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1334, 'en', 21, 'User', 'recoverAccountEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1335, 'en', 21, 'User', 'recoverAccountEvent', 'guide/emailAddress', ''),
(1336, 'en', 21, 'User', 'recoverAccountEvent', 'guide/memWord', 'If you see the form field Memorable word, then this means, that your e-mail address is related to such word and you must submit both (your email address and such a word) to ask for a new password and username.'),
(1337, 'en', 21, 'User', 'recoverAccountEvent', 'label/emailAddress', 'Email address*:'),
(1338, 'en', 21, 'User', 'recoverAccountEvent', 'label/memWord', 'Memorable word:'),
(1339, 'en', 21, 'User', 'recoverAccountEvent', 'value/submitEmail', 'Send email address'),
(1340, 'en', 21, 'User', 'recoverAccountEvent', 'value/submitWord', 'Send user details'),
(1341, 'en', 22, 'User', 'recoverAccountEvent', 'link1', 'Login'),
(1342, 'en', 22, 'User', 'recoverAccountEvent', 'message1', 'If you have forgotten your username and/or password, then on this page you can get new password and reminder of your username to your e-mail address, which you did submit and verify earlier on this website.'),
(1343, 'en', 22, 'User', 'recoverAccountEvent', 'message2', 'Please enter your e-mail address and click “Check email” button.'),
(1344, 'en', 22, 'User', 'recoverAccountEvent', 'message3', 'The question, which should help you to remember your memorable word, is following:'),
(1345, 'en', 22, 'User', 'recoverAccountEvent', 'message4', 'This e-mail address has been registered. Please carry on with the recovery process.'),
(1346, 'en', 22, 'User', 'recoverAccountEvent', 'message5', 'The memorable word is not set and in this case recovery can be done once in every [period] hours. Less than [period] hours have passed since the last recovery request.'),
(1347, 'en', 22, 'User', 'recoverAccountEvent', 'message6', 'An e-mail was sent to the given email address with username of the related account and with new password.'),
(1348, 'en', 22, 'User', 'recoverAccountEvent', 'message7', 'The memorable word is not correct.'),
(1349, 'en', 22, 'User', 'recoverAccountEvent', 'message8', 'This e-mail address has not been registered or verified.'),
(1350, 'en', 22, 'User', 'recoverAccountEvent', 'title', 'Account Recovery: Request for a New Password'),
(1351, 'en', 21, 'User', 'registerEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1352, 'en', 21, 'User', 'registerEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1353, 'en', 21, 'User', 'registerEvent', 'guide/email', ''),
(1354, 'en', 21, 'User', 'registerEvent', 'guide/password', ''),
(1355, 'en', 21, 'User', 'registerEvent', 'guide/password2', 'Type your password again.'),
(1356, 'en', 21, 'User', 'registerEvent', 'guide/username', ''),
(1357, 'en', 21, 'User', 'registerEvent', 'label/email', 'E-mail*:'),
(1358, 'en', 21, 'User', 'registerEvent', 'label/password', 'Password*:'),
(1359, 'en', 21, 'User', 'registerEvent', 'label/password2', 'Repeat password*:'),
(1360, 'en', 21, 'User', 'registerEvent', 'label/username', 'Username*:'),
(1361, 'en', 21, 'User', 'registerEvent', 'value/register', 'Register'),
(1362, 'en', 22, 'User', 'registerEvent', 'captchaNewCode', 'Get another code'),
(1363, 'en', 22, 'User', 'registerEvent', 'captchaBoxLabel', 'Type the characters in the image'),
(1364, 'en', 22, 'User', 'registerEvent', 'message1', 'Authentication email address (username) and/or password are not configured.'),
(1365, 'en', 22, 'User', 'registerEvent', 'message2', 'A link was sent to your e-mail address. Please check out your e-mail address and validate your email by clicking on this link.'),
(1366, 'en', 22, 'User', 'registerEvent', 'message3', 'This e-mail address has been already registered.'),
(1367, 'en', 22, 'User', 'registerEvent', 'message4', 'This username has been already registered.'),
(1368, 'en', 22, 'User', 'registerEvent', 'message5', 'Creating unique verifying code failed. Please try again.'),
(1369, 'en', 22, 'User', 'registerEvent', 'message6', 'Incorrect captcha code!'),
(1370, 'en', 22, 'User', 'registerEvent', 'passwordError', 'Password is not set or does not match with repeated password.'),
(1371, 'en', 22, 'User', 'registerEvent', 'title', 'Register to Get a User Account'),
(1372, 'en', 21, 'User', 'sendVerifyingCodeEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1373, 'en', 21, 'User', 'sendVerifyingCodeEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1374, 'en', 21, 'User', 'sendVerifyingCodeEvent', 'guide/emailAddress', ''),
(1375, 'en', 21, 'User', 'sendVerifyingCodeEvent', 'label/emailAddress', 'Email address*:'),
(1376, 'en', 21, 'User', 'sendVerifyingCodeEvent', 'value/submitEmail', 'Send email address'),
(1377, 'en', 22, 'User', 'sendVerifyingCodeEvent', 'authConfError', 'Authentication email address (username) and/or password are not configured.'),
(1378, 'en', 22, 'User', 'sendVerifyingCodeEvent', 'linkSent', 'A link was sent to your e-mail address. Please check out your e-mail address and validate your email by clicking on this link.'),
(1379, 'en', 22, 'User', 'sendVerifyingCodeEvent', 'message1', 'If you can not verify (activate) your email address, because the email with verifying link got lost, then here you can send a new verifying link to your email address.'),
(1380, 'en', 22, 'User', 'sendVerifyingCodeEvent', 'message2', 'This e-mail address has not been registered or is already verified.'),
(1381, 'en', 22, 'User', 'sendVerifyingCodeEvent', 'message3', 'The email address verifying link can be requested once in [period] hours. Less than [period] hours have passed since the last link request.'),
(1382, 'en', 22, 'User', 'sendVerifyingCodeEvent', 'message4', 'Creating unique verifying code failed. Please try again.'),
(1383, 'en', 22, 'User', 'sendVerifyingCodeEvent', 'title', 'Send a New Email Address Verifying Link'),
(1384, 'en', 21, 'User', 'signUpEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1385, 'en', 21, 'User', 'signUpEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1386, 'en', 21, 'User', 'signUpEvent', 'guide/addressLine1', 'Street, house number or name, flat number (if any).'),
(1387, 'en', 21, 'User', 'signUpEvent', 'guide/addressLine2', 'City or town or village or other similar administrative division.'),
(1388, 'en', 21, 'User', 'signUpEvent', 'guide/addressLine3', 'County.'),
(1389, 'en', 21, 'User', 'signUpEvent', 'guide/addressLine4', 'State or province or other similar administrative region.'),
(1390, 'en', 21, 'User', 'signUpEvent', 'guide/agreement', ''),
(1391, 'en', 21, 'User', 'signUpEvent', 'guide/comment', 'Any additional comment, which you wish to submit.'),
(1392, 'en', 21, 'User', 'signUpEvent', 'guide/company', ''),
(1393, 'en', 21, 'User', 'signUpEvent', 'guide/country', 'If your country is not in the list, then please choose the closest country (or last option Other) and describe your country name in comment field.'),
(1394, 'en', 21, 'User', 'signUpEvent', 'guide/email', ''),
(1395, 'en', 21, 'User', 'signUpEvent', 'guide/firstName', 'First name (forename, first given name).'),
(1396, 'en', 21, 'User', 'signUpEvent', 'guide/lastName', 'Last name (surname).'),
(1397, 'en', 21, 'User', 'signUpEvent', 'guide/middleNames', 'Middle names (other given names, if any, then separated by commas).'),
(1398, 'en', 21, 'User', 'signUpEvent', 'guide/password', ''),
(1399, 'en', 21, 'User', 'signUpEvent', 'guide/password2', 'Type your password again.'),
(1400, 'en', 21, 'User', 'signUpEvent', 'guide/phone1', 'Mobile or landline phone number.'),
(1401, 'en', 21, 'User', 'signUpEvent', 'guide/phone2', 'Another mobile or landline phone number.'),
(1402, 'en', 21, 'User', 'signUpEvent', 'guide/postalAddress', 'Whole postal address as it appears on official letters in your country. Your local official address format.'),
(1403, 'en', 21, 'User', 'signUpEvent', 'guide/postCode', 'Postal code or zip code or other similar code.'),
(1404, 'en', 21, 'User', 'signUpEvent', 'guide/username', ''),
(1405, 'en', 21, 'User', 'signUpEvent', 'label/addressLine1', 'Street, house, flat:'),
(1406, 'en', 21, 'User', 'signUpEvent', 'label/addressLine2', 'City / Town / Village:'),
(1407, 'en', 21, 'User', 'signUpEvent', 'label/addressLine3', 'County:'),
(1408, 'en', 21, 'User', 'signUpEvent', 'label/addressLine4', 'State / Province / Region:'),
(1409, 'en', 21, 'User', 'signUpEvent', 'label/agreement', ''),
(1410, 'en', 21, 'User', 'signUpEvent', 'label/comment', 'Comment:'),
(1411, 'en', 21, 'User', 'signUpEvent', 'label/company', 'Company:'),
(1412, 'en', 21, 'User', 'signUpEvent', 'label/country', 'Country*:'),
(1413, 'en', 21, 'User', 'signUpEvent', 'label/email', 'E-mail*:'),
(1414, 'en', 21, 'User', 'signUpEvent', 'label/firstName', 'First name*:'),
(1415, 'en', 21, 'User', 'signUpEvent', 'label/lastName', 'Last name*:'),
(1416, 'en', 21, 'User', 'signUpEvent', 'label/middleNames', 'Middle names:'),
(1417, 'en', 21, 'User', 'signUpEvent', 'label/password', 'Password*:'),
(1418, 'en', 21, 'User', 'signUpEvent', 'label/password2', 'Repeat password*:'),
(1419, 'en', 21, 'User', 'signUpEvent', 'label/phone1', 'Phone:'),
(1420, 'en', 21, 'User', 'signUpEvent', 'label/phone2', 'Second phone:'),
(1421, 'en', 21, 'User', 'signUpEvent', 'label/postalAddress', 'Postal address*:'),
(1422, 'en', 21, 'User', 'signUpEvent', 'label/postCode', 'Postal code:'),
(1423, 'en', 21, 'User', 'signUpEvent', 'label/username', 'Username*:'),
(1424, 'en', 21, 'User', 'signUpEvent', 'value/register', 'Register'),
(1425, 'en', 22, 'User', 'signUpEvent', 'captchaNewCode', 'Get another code'),
(1426, 'en', 22, 'User', 'signUpEvent', 'captchaBoxLabel', 'Type the characters in the image'),
(1427, 'en', 22, 'User', 'signUpEvent', 'agreementError', 'The agreement checkbox must be checked!'),
(1428, 'en', 22, 'User', 'signUpEvent', 'agreementLink', 'terms of service'),
(1429, 'en', 22, 'User', 'signUpEvent', 'agreementText', 'I agree to the'),
(1430, 'en', 22, 'User', 'signUpEvent', 'errorAuth', 'Authentication email address (username) and/or password are not configured.'),
(1431, 'en', 22, 'User', 'signUpEvent', 'errorCaptcha', 'Incorrect captcha code!'),
(1432, 'en', 22, 'User', 'signUpEvent', 'errorEmail', 'This e-mail address has been already registered.'),
(1433, 'en', 22, 'User', 'signUpEvent', 'errorUsername', 'This username has been already registered.'),
(1434, 'en', 22, 'User', 'signUpEvent', 'errorVerify', 'Creating unique verifying code failed. Please try again.'),
(1436, 'en', 22, 'User', 'signUpEvent', 'message1', 'Authentication email address (username) and/or password are not configured.'),
(1437, 'en', 22, 'User', 'signUpEvent', 'message2', 'A link was sent to your e-mail address. Please check out your e-mail address and validate your email by clicking on this link.'),
(1438, 'en', 22, 'User', 'signUpEvent', 'message3', 'This e-mail address has been already registered.'),
(1439, 'en', 22, 'User', 'signUpEvent', 'message4', 'This username has been already registered.'),
(1440, 'en', 22, 'User', 'signUpEvent', 'message5', 'Creating unique verifying code failed. Please try again.'),
(1441, 'en', 22, 'User', 'signUpEvent', 'message6', 'Incorrect captcha code!'),
(1442, 'en', 22, 'User', 'signUpEvent', 'passwordError', 'Password is not set or does not match with repeated password.'),
(1443, 'en', 22, 'User', 'signUpEvent', 'postalAddressTitle', 'Sign Up address'),
(1444, 'en', 22, 'User', 'signUpEvent', 'title', 'Sign up, to Get an User Account'),
(1445, 'en', 22, 'User', 'verifyEmailEvent', 'link1', 'Continue, Log in'),
(1446, 'en', 22, 'User', 'verifyEmailEvent', 'message1', 'Thank you for submitting the link. Your e-mail address has now been validated.'),
(1447, 'en', 22, 'User', 'verifyEmailEvent', 'message2', 'Sorry, but this is not a valid link or it has already been used for validating.'),
(1448, 'en', 21, 'Search', 'indexEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1449, 'en', 21, 'Search', 'indexEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1450, 'en', 21, 'Search', 'indexEvent', 'guide/searchType', 'Choose the option, which explains what sort of data will be searched for.'),
(1451, 'en', 21, 'Search', 'indexEvent', 'guide/searchPhrase', 'Write here the search phrase or keyword(s) which you wish to use by searching. By default space (" ") and characters "*" and "%" in the phrase will be used as wild characters to search for 0 or more not determined symbols (e.g. [keyword1 keyword2]). If you wish to find an exact phrase, i.e. to use space as part of the search phrase (not as wild character), then start and end the whole search phrase with (double) quotes (e.g. ["your exact search phrase"]).'),
(1452, 'en', 21, 'Search', 'indexEvent', 'label/searchType', 'Search location:'),
(1453, 'en', 21, 'Search', 'indexEvent', 'label/searchPhrase', 'Search phrase:'),
(1454, 'en', 21, 'Search', 'indexEvent', 'value/search', 'Search'),
(1455, 'en', 22, 'Search', 'indexEvent', 'message1', 'Total entries found: [noOfAllItems]'),
(1456, 'en', 22, 'Search', 'indexEvent', 'message2', 'Current search result page: [curPage] of [allPages]'),
(1457, 'en', 22, 'Search', 'indexEvent', 'message3', 'There is no search result.'),
(1458, 'en', 22, 'Search', 'indexEvent', 'message4', 'There are no search options yet or search type id is not correct or you do not have access right for the content corresponding to this search type!'),
(1459, 'en', 22, 'Search', 'indexEvent', 'tb1Title', 'List of Search result'),
(1460, 'en', 22, 'Search', 'indexEvent', 'link1', 'Link'),
(1461, 'en', 21, 'Search', 'listByTypeEvent', 'formErrorEmpty', 'Form field “[elLabel]” can not be empty!'),
(1462, 'en', 21, 'Search', 'listByTypeEvent', 'formErrorGeneral', 'Field “[elLabel]” is invalid!'),
(1463, 'en', 21, 'Search', 'listByTypeEvent', 'guide/searchPhrase', 'Use quotes to find content, which contains exact search phrase (e.g. ["your exact search phrase"]). Use no quotes to find content, which contains all the keywords in the order as they are on search field (e.g. [keyword1 keyword2]).'),
(1464, 'en', 21, 'Search', 'listByTypeEvent', 'label/searchPhrase', 'Search phrase:'),
(1465, 'en', 21, 'Search', 'listByTypeEvent', 'value/search', 'Search'),
(1466, 'en', 22, 'Search', 'listByTypeEvent', 'message1', 'Total entries found: [noOfAllItems]'),
(1467, 'en', 22, 'Search', 'listByTypeEvent', 'message2', 'Current search result page: [curPage] of [allPages]'),
(1468, 'en', 22, 'Search', 'listByTypeEvent', 'message3', 'There is no search result.'),
(1469, 'en', 22, 'Search', 'listByTypeEvent', 'message4', 'There are no search options yet or search type id is not correct or you do not have access right for the content corresponding to this search type!'),
(1470, 'en', 22, 'Search', 'listByTypeEvent', 'tb1Title', 'List of Search result'),
(1471, 'en', 22, 'Search', 'listByTypeEvent', 'link1', 'Link'),
(1472, 'en', 22, 'Search', 'listByTypeEvent', 'noAccess', 'No Access'),
(1473, 'en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeName', 'Theme name'),
(1474, 'en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeTitle', 'Theme title'),
(1475, 'en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeDesc', 'Theme description'),
(1476, 'en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeVersion', 'Theme version'),
(1477, 'en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeTime', 'Theme release time'),
(1478, 'en', 22, 'Theme', 'installThemesEvent', 'tb1ThemeDeveloper', 'Theme developer'),
(1479, 'en', 22, 'Theme', 'installThemesEvent', 'title', 'Install Themes'),
(1480, 'en', 22, 'Theme', 'installThemesEvent', 'link1', 'Administrator menu'),
(1481, 'en', 22, 'Theme', 'installThemesEvent', 'tb1Title', 'Uninstalled themes'),
(1482, 'en', 22, 'Theme', 'installThemesEvent', 'tb2Title', 'Installed themes'),
(1483, 'en', 22, 'Theme', 'installThemesEvent', 'text1NoUninsThemes', 'There are no uninstalled themes.'),
(1484, 'en', 22, 'Theme', 'installThemesEvent', 'text2NoInsThemes', 'There are no installed themes.'),
(1485, 'en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeName', 'Theme name'),
(1486, 'en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeTitle', 'Theme title'),
(1487, 'en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeDesc', 'Theme description'),
(1488, 'en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeVersion', 'Theme version'),
(1489, 'en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeTime', 'Theme release time'),
(1490, 'en', 22, 'Theme', 'uninstallThemesEvent', 'tb1ThemeDeveloper', 'Theme developer'),
(1491, 'en', 22, 'Theme', 'uninstallThemesEvent', 'title', 'Uninstall themes'),
(1492, 'en', 22, 'Theme', 'uninstallThemesEvent', 'link1', 'Administrator menu'),
(1493, 'en', 22, 'Theme', 'uninstallThemesEvent', 'tb1Title', 'Uninstalled themes'),
(1494, 'en', 22, 'Theme', 'uninstallThemesEvent', 'tb2Title', 'Installed themes'),
(1495, 'en', 22, 'Theme', 'uninstallThemesEvent', 'text1NoUninsThemes', 'There are no uninstalled themes.'),
(1496, 'en', 22, 'Theme', 'uninstallThemesEvent', 'text2NoInsThemes', 'There are no installed themes.'),
(1497, 'en', 22, 'User', 'contactFormEvent', 'messageSent', 'Message was sent.'),
(1498, 'en', 11, 'Language', 'setChooserBlock:langOptions', 'title', 'Language Picker'),
(1499, 'en', 11, 'Language', 'setChooserBlock:langOptions', 'label1', 'Active language is:'),
(1500, 'en', 11, 'Language', 'setChooserBlock:langOptions', 'label2', 'Choose another language:'),
(1501, 'en', 11, 'Language', 'setChooserBlock:langLink', 'buttonStart1', 'Change language'),
(1502, 'en', 22, 'Page', 'editAnyPageEvent', 'submitMessageEnd', '.'),
(1503, 'en', 22, 'OwnPage', 'editPageEvent', 'submitMessageEnd', '.'),
(1504, 'en', 22, 'Page', 'editAnyPageEvent', 'aliasProblem', 'Alias is not correct and page was not saved. Most common causes for this problem: This alias may already exist for another page or starts with path of an installed module or does not have a leading slash (/) or has many leading slashes.'),
(1505, 'en', 22, 'OwnPage', 'editPageEvent', 'aliasProblem', 'Alias is not correct and page was not saved. Most common causes for this problem: This alias may already exist for another page or starts with path of an installed module or does not have a leading slash (/) or has many leading slashes.'),
(1506, 'en', 22, 'User', 'listContactFormsEvent', 'link4', 'Contact form'),
(1507, 'en', 22, 'OwnPage', 'indexEvent', 'link1', 'Add a new page'),
(1508, 'en', 22, 'OwnPage', 'indexEvent', 'buttonShowCols', 'Show more columns'),
(1509, 'en', 22, 'OwnPage', 'indexEvent', 'buttonHideCols', 'Hide some columns'),
(1510, 'en', 22, 'OwnPage', 'listPagesEvent', 'buttonShowCols', 'Show more columns'),
(1511, 'en', 22, 'OwnPage', 'listPagesEvent', 'buttonHideCols', 'Hide some columns'),
(1512, 'en', 22, 'Page', 'indexEvent', 'buttonShowCols', 'Show more columns'),
(1513, 'en', 22, 'Page', 'indexEvent', 'buttonHideCols', 'Hide some columns'),
(1514, 'en', 22, 'Page', 'listAllPagesEvent', 'buttonShowCols', 'Show more columns'),
(1515, 'en', 22, 'Page', 'listAllPagesEvent', 'buttonHideCols', 'Hide some columns'),
(1516, 'en', 22, 'User', 'deleteAccountEvent', 'message3', 'You are trying to delete an user account, which does not exist or which you can not delete.'),
(1517, 'en', 22, 'Search', 'indexEvent', 'link1label', 'Link'),
(1518, 'en', 22, 'Search', 'indexEvent', 'link1text', 'Click here!'),
(1519, 'en', 22, 'Search', 'listByTypeEvent', 'link1label', 'Link'),
(1520, 'en', 22, 'Search', 'listByTypeEvent', 'link1text', 'Click here!'),
(1521, 'en', 22, 'Message', 'deleteTemplateEvent', 'beforeMessage2', 'Message template details are:'),
(1522, 'en', 22, 'Message', 'deleteMessageEvent', 'beforeMessage2', 'Message details are:'),
(1523, 'en', 22, 'Page', 'deleteAnyPageEvent', 'beforeMessage2', 'Page details are:'),
(1524, 'en', 22, 'Page', 'deletePostEvent', 'beforeMessage2', 'Post details are:'),
(1525, 'en', 22, 'Page', 'deleteSnippetEvent', 'beforeMessage2', 'Snippet details are:'),
(1526, 'en', 22, 'OwnPage', 'deletePageEvent', 'beforeMessage2', 'Page details are:'),
(1527, 'en', 22, 'OwnPage', 'deletePostEvent', 'beforeMessage2', 'Post details are:'),
(1528, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'beforeMessage2', 'Snippet details are:'),
(1529, 'en', 22, 'OwnPage', 'deleteSnippetEvent', 'submitYes', 'Delete this snippet!'),
(1530, 'en', 22, 'Page', 'viewEvent', 'link2', 'PDF'),
(1531, 'en', 22, 'Page', 'viewPdfEvent', 'footerText', 'Page');

-- --------------------------------------------------------

--
-- Table structure for table `core_misc_data`
--

CREATE TABLE `core_misc_data` (
  `id` int(11) NOT NULL,
  `integer_value` int(11) NOT NULL DEFAULT '0',
  `module_name` varchar(30) NOT NULL DEFAULT '',
  `uri` varchar(60) NOT NULL DEFAULT '',
  `type` varchar(30) NOT NULL DEFAULT '',
  `value` varchar(2000) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_misc_data`
--

INSERT INTO `core_misc_data` (`id`, `integer_value`, `module_name`, `uri`, `type`, `value`) VALUES
(1, 0, 'GlobalObserver', 'lastDeletingTime', 'indexEvent', '1545736376'),
(2, 0, 'GlobalObserver', 'lastBackupTime', 'indexEvent', '0');

-- --------------------------------------------------------

--
-- Table structure for table `core_module`
--

CREATE TABLE `core_module` (
  `id` smallint(5) NOT NULL,
  `name` varchar(30) NOT NULL COMMENT 'Computer identifier for the module',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT 'Human readable title for the module',
  `description` varchar(510) NOT NULL DEFAULT '',
  `path` varchar(30) NOT NULL DEFAULT '' COMMENT 'Part of URL',
  `config_path` varchar(60) NOT NULL DEFAULT '',
  `code_path` varchar(60) NOT NULL DEFAULT '',
  `type` tinyint(3) NOT NULL DEFAULT '2' COMMENT '1- global; 2- local; 11- global core; 12- local core; 21- global custom; 22- local custom',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0: not installed; 1: installed',
  `db_tables` varchar(255) NOT NULL DEFAULT '',
  `required_modules` varchar(255) NOT NULL DEFAULT '',
  `version` varchar(30) NOT NULL DEFAULT '1.1.1',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT 'Version publishing timestamp',
  `developer` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_module`
--

INSERT INTO `core_module` (`id`, `name`, `title`, `description`, `path`, `config_path`, `code_path`, `type`, `status`, `db_tables`, `required_modules`, `version`, `time`, `developer`) VALUES
(1, 'App', 'App', 'This module is part of Allmice CMS Core for installing websites and modules', 'app', '', 'core/modules/', 2, 0, '', '', '1.7.1', 1572208377, 'Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Allmice CMS Core code is released under the \"GNU GENERAL PUBLIC LICENSE\".'),
(2, 'AppUser', 'App User', 'This module is part of Allmice CMS Core for login and logout functionality', 'app-user', '', 'core/modules/', 2, 0, '', '', '1.7.1', 1572208377, 'Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Allmice CMS Core code is released under the \"GNU GENERAL PUBLIC LICENSE\".'),
(3, 'GlobalCore', 'Global Core', 'This module is part of Allmice CMS Core for Allmice CMS core functionality', '', '', 'core/modules/', 1, 0, '', '', '1.7.1', 1572208377, 'Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Allmice CMS Core code is released under the \"GNU GENERAL PUBLIC LICENSE\".'),
(4, 'Admin', 'Admin', 'This module helps to add, edit and delete various admin data for Allmice CMS', 'admin', '', '', 22, 1, '', '', '1.7.1', 1572208377, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Admin module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(5, 'Block', 'Block', 'This module helps to add, edit and delete block data for Allmice CMS core block functionality', 'block', 'modules/Block/config-block.php', '', 22, 1, '', '', '1.7.1', 1572208377, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Block module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(6, 'Menu', 'Menu', 'This is a simple menu module, which includes most common website functionality', 'menu', '', '', 22, 1, 'mod_menu, mod_menu_item', '', '1.7.1', 1572208377, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Menu module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(7, 'SystemManager', 'System Manager', 'This module helps to install, uninstall and update other modules for Allmice CMS. It is an extension of core App module. The updating process (structure events) involves uninstalling and installing modules without deleting and without overwriting data.', 'system-manager', '', '', 22, 1, '', '', '1.7.1', 1574144952, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, System Manager module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(8, 'FormField', 'Form Field', 'This module makes it possible to change some properties of the form fields of module events.', 'form-field', '', '', 22, 1, 'mod_form_field', '', '1.7.1', 1572208377, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Form Field module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(9, 'GlobalObserver', 'Global Observer', 'This is a global module, which records visitors data (including consent signals related to EU General Data Processing Regulation) into database.', '', '', '', 21, 1, 'mod_global_observer_visitor, mod_global_observer_location, mod_global_observer_event', '', '1.7.1', 1572208377, 'A stable module. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, Global Observer module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(10, 'Message', 'Message', 'This message module can be used to manage e-mail, log and other possible messages. It has also methods to manage templates for creating outgoing e-mails or system log messages.', 'message', '', '', 22, 1, 'mod_message, mod_message_template', '', '1.7.1', 1572208377, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Message module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(11, 'Page', 'Page', 'This is a simple page module, which includes most common website functionality. This module has multi language support.', 'page', '', '', 22, 1, 'mod_page, mod_page_post, mod_page_snippet', '#Menu#', '1.7.1', 1574144952, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Page module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(12, 'Profile', 'Profile', 'This module helps to customize user&#39;s profile.', 'profile', '', '', 22, 1, 'mod_profile', '', '1.7.1', 1572208377, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Profile module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(13, 'OwnPage', 'Own Page', 'This is a simple page module, which includes most common website functionality. Only the owner of the pages can use the functionality of this module (for other purposes use module Page). This module has multi language support.', 'own-page', '', '', 22, 1, '', '#Menu#Page#', '1.7.1', 1572208377, 'A stable module. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, Own Page module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(14, 'User', 'User', 'This module is an extension to the AppUser and Admin modules. It helps to add, edit and delete various user data (including register users with e-mail validation), allows contact forms and other e-mail messages and performs authentication (logging functionality). If using this module, then it is suggested not to use Admin module user event methods.', 'user', '', '', 22, 1, 'mod_user, mod_user_contact, mod_user_country, mod_user_email, mod_user_postal', '#Message#FormField#SystemManager#', '1.7.1', 1572208377, 'A stable module. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, User module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(15, 'Search', 'Search', 'This is a search module.', 'search', '', '', 22, 1, 'mod_search', '', '1.7.1', 1572208377, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Search module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(16, 'Theme', 'Theme', 'This is theme module', 'theme', '', '', 22, 1, '', '', '1.7.1', 1572208377, 'A stable module. Copyright 2017 - 2019 by Any Outline LTD, www.allmice.com/cms, Theme module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(17, 'Language', 'Language', 'This is a language module, which includes language editing functionality.', 'language', '', '', 22, 1, 'mod_language, mod_language_item', '#Block#Page#', '1.7.1', 1572208377, 'A stable module. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, Language module is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.');

-- --------------------------------------------------------

--
-- Table structure for table `core_resource`
--

CREATE TABLE `core_resource` (
  `id` int(11) NOT NULL,
  `uri` varchar(200) NOT NULL DEFAULT '' COMMENT 'Relevant if type is Event: 1 or Page: 2. Uri is meaning here shortly unique resource identifier. In current context and system uri is not referring to some strict worldwide standard.',
  `source_id` int(11) NOT NULL DEFAULT '0',
  `module_name` varchar(30) NOT NULL,
  `specific_name` varchar(30) NOT NULL COMMENT 'According to type event or region name',
  `type` tinyint(3) NOT NULL COMMENT 'None: 0; Event: 1; Page: 21; Block: 40-59 (Block: 40, Menu: 41)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_resource`
--

INSERT INTO `core_resource` (`id`, `uri`, `source_id`, `module_name`, `specific_name`, `type`) VALUES
(1, '/app/index', 0, 'App', 'index', 1),
(2, '/app/install', 0, 'App', 'install', 1),
(3, '/app/install-modules', 0, 'App', 'installModules', 1),
(4, '/app/uninstall-modules', 0, 'App', 'uninstallModules', 1),
(5, '/app/manage-access', 0, 'App', 'manageAccess', 1),
(6, '/app-user/index', 0, 'AppUser', 'index', 1),
(7, '/app-user/login', 0, 'AppUser', 'login', 1),
(8, '/app-user/logout', 0, 'AppUser', 'logout', 1),
(9, '/block/view/1', 1, 'GlobalCore', 'appUserArea', 40),
(10, '/theme/view/1', 1, 'GlobalCore', 'AllmiceDefault', 60),
(11, '/block/view/3', 3, 'GlobalCore', 'coreFooterArea', 40),
(12, '/admin/index', 0, 'Admin', 'index', 1),
(13, '/admin/list-users', 0, 'Admin', 'listUsers', 1),
(14, '/admin/add-user', 0, 'Admin', 'addUser', 1),
(15, '/admin/edit-user', 0, 'Admin', 'editUser', 1),
(16, '/admin/assign-roles', 0, 'Admin', 'assignRoles', 1),
(17, '/admin/delete-user', 0, 'Admin', 'deleteUser', 1),
(18, '/admin/list-roles', 0, 'Admin', 'listRoles', 1),
(19, '/admin/add-role', 0, 'Admin', 'addRole', 1),
(20, '/admin/edit-role', 0, 'Admin', 'editRole', 1),
(21, '/admin/delete-role', 0, 'Admin', 'deleteRole', 1),
(22, '/admin/list-aliases', 0, 'Admin', 'listAliases', 1),
(23, '/admin/add-alias', 0, 'Admin', 'addAlias', 1),
(24, '/admin/edit-alias', 0, 'Admin', 'editAlias', 1),
(25, '/admin/delete-alias', 0, 'Admin', 'deleteAlias', 1),
(26, '/admin/list-bot-access-resources', 0, 'Admin', 'listBotAccessResources', 1),
(27, '/admin/edit-bot-access', 0, 'Admin', 'editBotAccess', 1),
(28, '/admin/list-config', 0, 'Admin', 'listConfig', 1),
(29, '/admin/add-config', 0, 'Admin', 'addConfig', 1),
(30, '/admin/edit-config', 0, 'Admin', 'editConfig', 1),
(31, '/admin/delete-config', 0, 'Admin', 'deleteConfig', 1),
(32, '/block/index', 0, 'Block', 'index', 1),
(33, '/block/list-blocks', 0, 'Block', 'listBlocks', 1),
(34, '/block/add', 0, 'Block', 'add', 1),
(35, '/block/edit', 0, 'Block', 'edit', 1),
(36, '/block/delete', 0, 'Block', 'delete', 1),
(37, '/menu/index', 0, 'Menu', 'index', 1),
(38, '/menu/view', 0, 'Menu', 'view', 1),
(39, '/menu/list-menus', 0, 'Menu', 'listMenus', 1),
(40, '/menu/add-menu', 0, 'Menu', 'addMenu', 1),
(41, '/menu/edit-menu', 0, 'Menu', 'editMenu', 1),
(42, '/menu/delete-menu', 0, 'Menu', 'deleteMenu', 1),
(43, '/menu/list-menu-items', 0, 'Menu', 'listMenuItems', 1),
(44, '/menu/add-menu-item', 0, 'Menu', 'addMenuItem', 1),
(45, '/menu/edit-menu-item', 0, 'Menu', 'editMenuItem', 1),
(46, '/menu/delete-menu-item', 0, 'Menu', 'deleteMenuItem', 1),
(47, '/menu/build-module-menu', 0, 'Menu', 'buildModuleMenu', 1),
(48, '/system-manager/index', 0, 'SystemManager', 'index', 1),
(49, '/system-manager/manage-access', 0, 'SystemManager', 'manageAccess', 1),
(50, '/system-manager/install-modules', 0, 'SystemManager', 'installModules', 1),
(51, '/system-manager/uninstall-modules', 0, 'SystemManager', 'uninstallModules', 1),
(52, '/system-manager/uninstall-module-structure', 0, 'SystemManager', 'uninstallModuleStructure', 1),
(53, '/system-manager/install-module-structure', 0, 'SystemManager', 'installModuleStructure', 1),
(54, '/system-manager/add-edit-tsv-set', 0, 'SystemManager', 'addEditTsvSet', 1),
(55, '/system-manager/delete-tsv-set', 0, 'SystemManager', 'deleteTsvSet', 1),
(56, '/system-manager/list-tsv-set', 0, 'SystemManager', 'listTsvSet', 1),
(57, '/menu/view/1', 1, 'Menu', 'adminGeneralMenu', 41),
(58, '/block/view/4', 4, 'Block', 'adminGeneralMenu', 40),
(59, '/form-field/index', 0, 'FormField', 'index', 1),
(60, '/form-field/list-fields', 0, 'FormField', 'listFields', 1),
(61, '/form-field/add', 0, 'FormField', 'add', 1),
(62, '/form-field/edit', 0, 'FormField', 'edit', 1),
(63, '/form-field/delete', 0, 'FormField', 'delete', 1),
(64, '//index', 0, 'GlobalObserver', 'index', 1),
(65, '/message/index', 0, 'Message', 'index', 1),
(66, '/message/list-templates', 0, 'Message', 'listTemplates', 1),
(67, '/message/add-template', 0, 'Message', 'addTemplate', 1),
(68, '/message/edit-template', 0, 'Message', 'editTemplate', 1),
(69, '/message/delete-template', 0, 'Message', 'deleteTemplate', 1),
(70, '/message/write-message', 0, 'Message', 'writeMessage', 1),
(71, '/message/edit-message', 0, 'Message', 'editMessage', 1),
(72, '/message/delete-message', 0, 'Message', 'deleteMessage', 1),
(73, '/message/list-messages', 0, 'Message', 'listMessages', 1),
(74, '/message/view-message', 0, 'Message', 'viewMessage', 1),
(75, '/message/list-all-messages', 0, 'Message', 'listAllMessages', 1),
(76, '/message/view-any-message', 0, 'Message', 'viewAnyMessage', 1),
(77, '/message/delete-any-message', 0, 'Message', 'deleteAnyMessage', 1),
(78, '/message/list-user-blockings', 0, 'Message', 'listUserBlockings', 1),
(79, '/message/add-user-blocking', 0, 'Message', 'addUserBlocking', 1),
(80, '/message/remove-user-blocking', 0, 'Message', 'removeUserBlocking', 1),
(81, '/page/index', 0, 'Page', 'index', 1),
(82, '/page/list-all-pages', 0, 'Page', 'listAllPages', 1),
(83, '/page/view', 0, 'Page', 'view', 1),
(84, '/page/add-page', 0, 'Page', 'addPage', 1),
(85, '/page/edit-any-page', 0, 'Page', 'editAnyPage', 1),
(86, '/page/delete-any-page', 0, 'Page', 'deleteAnyPage', 1),
(87, '/page/manage-posting-access', 0, 'Page', 'managePostingAccess', 1),
(88, '/page/list-snippets', 0, 'Page', 'listSnippets', 1),
(89, '/page/add-snippet', 0, 'Page', 'addSnippet', 1),
(90, '/page/edit-snippet', 0, 'Page', 'editSnippet', 1),
(91, '/page/delete-snippet', 0, 'Page', 'deleteSnippet', 1),
(92, '/page/edit-post', 0, 'Page', 'editPost', 1),
(93, '/page/delete-post', 0, 'Page', 'deletePost', 1),
(94, '/profile/index', 0, 'Profile', 'index', 1),
(95, '/own-page/index', 0, 'OwnPage', 'index', 1),
(96, '/own-page/list-pages', 0, 'OwnPage', 'listPages', 1),
(97, '/own-page/edit-page', 0, 'OwnPage', 'editPage', 1),
(98, '/own-page/delete-page', 0, 'OwnPage', 'deletePage', 1),
(99, '/own-page/manage-posting-access', 0, 'OwnPage', 'managePostingAccess', 1),
(100, '/own-page/list-snippets', 0, 'OwnPage', 'listSnippets', 1),
(101, '/own-page/add-snippet', 0, 'OwnPage', 'addSnippet', 1),
(102, '/own-page/edit-snippet', 0, 'OwnPage', 'editSnippet', 1),
(103, '/own-page/delete-snippet', 0, 'OwnPage', 'deleteSnippet', 1),
(104, '/own-page/edit-post', 0, 'OwnPage', 'editPost', 1),
(105, '/own-page/delete-post', 0, 'OwnPage', 'deletePost', 1),
(106, '/user/index', 0, 'User', 'index', 1),
(107, '/user/login', 0, 'User', 'login', 1),
(108, '/user/logout', 0, 'User', 'logout', 1),
(109, '/user/my-account-options', 0, 'User', 'myAccountOptions', 1),
(110, '/user/sign-up', 0, 'User', 'signUp', 1),
(111, '/user/register', 0, 'User', 'register', 1),
(112, '/user/verify-email', 0, 'User', 'verifyEmail', 1),
(113, '/user/contact-form', 0, 'User', 'contactForm', 1),
(114, '/user/list-email-addresses', 0, 'User', 'listEmailAddresses', 1),
(115, '/user/list-contact-forms', 0, 'User', 'listContactForms', 1),
(116, '/user/list-postal-addresses', 0, 'User', 'listPostalAddresses', 1),
(117, '/user/add-email-address', 0, 'User', 'addEmailAddress', 1),
(118, '/user/edit-email-address', 0, 'User', 'editEmailAddress', 1),
(119, '/user/delete-email-address', 0, 'User', 'deleteEmailAddress', 1),
(120, '/user/add-contact-form', 0, 'User', 'addContactForm', 1),
(121, '/user/edit-contact-form', 0, 'User', 'editContactForm', 1),
(122, '/user/delete-contact-form', 0, 'User', 'deleteContactForm', 1),
(123, '/user/add-postal-address', 0, 'User', 'addPostalAddress', 1),
(124, '/user/edit-postal-address', 0, 'User', 'editPostalAddress', 1),
(125, '/user/delete-postal-address', 0, 'User', 'deletePostalAddress', 1),
(126, '/user/edit-account', 0, 'User', 'editAccount', 1),
(127, '/user/delete-account', 0, 'User', 'deleteAccount', 1),
(128, '/user/list-accounts', 0, 'User', 'listAccounts', 1),
(129, '/user/list-all-email-addresses', 0, 'User', 'listAllEmailAddresses', 1),
(130, '/user/list-all-postal-addresses', 0, 'User', 'listAllPostalAddresses', 1),
(131, '/user/list-all-contact-forms', 0, 'User', 'listAllContactForms', 1),
(132, '/user/add-account', 0, 'User', 'addAccount', 1),
(133, '/user/edit-any-account', 0, 'User', 'editAnyAccount', 1),
(134, '/user/delete-any-account', 0, 'User', 'deleteAnyAccount', 1),
(135, '/user/add-any-email-address', 0, 'User', 'addAnyEmailAddress', 1),
(136, '/user/edit-any-email-address', 0, 'User', 'editAnyEmailAddress', 1),
(137, '/user/delete-any-email-address', 0, 'User', 'deleteAnyEmailAddress', 1),
(138, '/user/add-any-contact-form', 0, 'User', 'addAnyContactForm', 1),
(139, '/user/edit-any-contact-form', 0, 'User', 'editAnyContactForm', 1),
(140, '/user/delete-any-contact-form', 0, 'User', 'deleteAnyContactForm', 1),
(141, '/user/add-any-postal-address', 0, 'User', 'addAnyPostalAddress', 1),
(142, '/user/edit-any-postal-address', 0, 'User', 'editAnyPostalAddress', 1),
(143, '/user/delete-any-postal-address', 0, 'User', 'deleteAnyPostalAddress', 1),
(144, '/user/recover-account', 0, 'User', 'recoverAccount', 1),
(145, '/user/send-verifying-code', 0, 'User', 'sendVerifyingCode', 1),
(146, '/user/change-user-status', 0, 'User', 'changeUserStatus', 1),
(147, '/menu/view/2', 2, 'Menu', 'adminUserMenu', 41),
(148, '/block/view/6', 6, 'Block', 'adminUserMenu', 40),
(149, '/search/index', 0, 'Search', 'index', 1),
(150, '/search/list-by-type', 0, 'Search', 'listByType', 1),
(151, '/search/add-type', 0, 'Search', 'addType', 1),
(152, '/search/edit-type', 0, 'Search', 'editType', 1),
(153, '/search/delete-type', 0, 'Search', 'deleteType', 1),
(154, '/search/list-types', 0, 'Search', 'listTypes', 1),
(155, '/menu/view/3', 3, 'Menu', 'myAccount', 41),
(156, '/block/view/7', 7, 'Block', 'myAccount', 40),
(157, '/theme/index', 0, 'Theme', 'index', 1),
(158, '/theme/install-themes', 0, 'Theme', 'installThemes', 1),
(159, '/theme/uninstall-themes', 0, 'Theme', 'uninstallThemes', 1),
(160, '/theme/choose-default-theme', 0, 'Theme', 'chooseDefaultTheme', 1),
(161, '/theme/change-theme-colors', 0, 'Theme', 'changeThemeColors', 1),
(162, '/theme/replace-css-declarations', 0, 'Theme', 'replaceCssDeclarations', 1),
(163, '/theme/create-css-from-template', 0, 'Theme', 'createCssFromTemplate', 1),
(164, '/block/view/8', 8, 'Block', 'loginBlock', 40),
(165, '/theme/view/11', 11, 'Theme', 'ClassicBase', 60),
(166, '/theme/view/12', 12, 'Theme', 'ClassicBlueThree', 60),
(167, '/theme/view/13', 13, 'Theme', 'ClassicRightCherry', 60),
(168, '/theme/view/14', 14, 'Theme', 'MobileBase', 60),
(169, '/theme/view/15', 15, 'Theme', 'MobileGreen', 60),
(170, '/theme/view/16', 16, 'Theme', 'MousyBase', 60),
(171, '/theme/view/17', 17, 'Theme', 'MousyBlue', 60),
(172, '/theme/view/18', 18, 'Theme', 'MousyGreen', 60),
(173, '/language/index', 0, 'Language', 'index', 1),
(174, '/language/list-languages', 0, 'Language', 'listLanguages', 1),
(175, '/language/add-language-details', 0, 'Language', 'addLanguageDetails', 1),
(176, '/language/edit-language-details', 0, 'Language', 'editLanguageDetails', 1),
(177, '/language/delete-language-details', 0, 'Language', 'deleteLanguageDetails', 1),
(178, '/language/add-edit-phrase-set', 0, 'Language', 'addEditPhraseSet', 1),
(179, '/language/delete-phrase-set', 0, 'Language', 'deletePhraseSet', 1),
(180, '/language/view-phrase-set-table', 0, 'Language', 'viewPhraseSetTable', 1),
(181, '/language/list-phrases', 0, 'Language', 'listPhrases', 1),
(182, '/language/add-phrase', 0, 'Language', 'addPhrase', 1),
(183, '/language/edit-phrase', 0, 'Language', 'editPhrase', 1),
(184, '/language/delete-phrase', 0, 'Language', 'deletePhrase', 1),
(185, '/language/manage-language-file', 0, 'Language', 'manageLanguageFile', 1),
(186, '/language/list-relations', 0, 'Language', 'listRelations', 1),
(187, '/language/list-pages', 0, 'Language', 'listPages', 1),
(188, '/language/add-relation', 0, 'Language', 'addRelation', 1),
(189, '/language/edit-relation', 0, 'Language', 'editRelation', 1),
(190, '/language/delete-relation', 0, 'Language', 'deleteRelation', 1),
(191, '/page/view/1', 1, 'Page', 'view', 21),
(192, '/block/view/5', 5, 'Block', 'consentMessage', 40),
(193, '/page/view-pdf', 0, 'Page', 'viewPdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `core_role`
--

CREATE TABLE `core_role` (
  `id` smallint(5) NOT NULL,
  `title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_role`
--

INSERT INTO `core_role` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'anonymous'),
(3, 'authenticated');

-- --------------------------------------------------------

--
-- Table structure for table `core_session`
--

CREATE TABLE `core_session` (
  `id` varchar(32) NOT NULL,
  `access` int(10) UNSIGNED DEFAULT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `core_theme`
--

CREATE TABLE `core_theme` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(500) NOT NULL,
  `code_path` varchar(60) NOT NULL,
  `version` varchar(30) NOT NULL,
  `time` int(11) NOT NULL COMMENT 'Version publishing timestamp',
  `developer` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_theme`
--

INSERT INTO `core_theme` (`id`, `name`, `title`, `description`, `code_path`, `version`, `time`, `developer`) VALUES
(1, 'AllmiceDefault', 'Allmice Default Theme', 'Default theme for Allmice CMS with teal color shades and fixed navibar. This is a mobile-friendly theme.', 'core/themes/', '1.7.1', 1574136840, 'Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, Allmice Default Theme is released under the \"GNU GENERAL PUBLIC LICENSE\".'),
(11, 'ClassicBase', 'Classic Base Theme', 'A changeable base theme for Allmice CMS. In non-mobile device it has left sidebar for menu area. If menu area is not used, then left sidebar is hidden. In case of mobile devices no sidebar will be used and the layout with styles will be in this case mobile device friendly.', 'themes/', '1.7.1', 1574136840, 'Stable theme. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, This theme is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(12, 'ClassicBlue', 'Classic Blue Theme', 'A changeable theme for Allmice CMS, which uses Classic Base theme components. In non-mobile device it has two sidebars - left and right. This theme has blue color shades.', 'themes/', '1.7.1', 1574136840, 'Stable theme. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, This theme is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(13, 'ClassicCherry', 'Classic Cherry Theme', 'A changeable theme for Allmice CMS, which uses Classic Base theme components. In a non-mobile device it has right sidebar for menu area. If menu area is not used, then right sidebar is hidden. This theme has cherry red color shades.', 'themes/', '1.7.1', 1574136840, 'Stable theme. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, This theme is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(14, 'MobileBase', 'Mobile Base Theme', 'A simple mobile friendly Base theme for Allmice CMS.', 'themes/', '1.7.1', 1574136840, 'Stable theme. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, This theme is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(15, 'MobileGreen', 'Mobile Green Theme', 'A green version of Mobile Base theme for Allmice CMS.', 'themes/', '1.7.1', 1574136840, 'Stable theme. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, This theme is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(16, 'MousyBase', 'Mousy Base Theme', 'A simple modern base theme for Allmice CMS with teal color shades and fixed navibar. In case of mobile devices no sidebar will be used and the layout with styles will be in this case mobile device friendly.', 'themes/', '1.7.1', 1574136840, 'Stable theme. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, This theme is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(17, 'MousyBlue', 'Mousy Blue Theme', 'A blue version of Mousy Base theme for Allmice CMS.', 'themes/', '1.7.1', 1574136840, 'Stable theme. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, This theme is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.'),
(18, 'MousyGreen', 'Mousy Green Theme', 'A green version of Mousy Base theme for Allmice CMS.', 'themes/', '1.7.1', 1574136840, 'Stable theme. Copyright 2018 - 2019 by Any Outline LTD, www.allmice.com/cms, This theme is released under the &#39;GNU GENERAL PUBLIC LICENSE&#39;.');

-- --------------------------------------------------------

--
-- Table structure for table `core_user`
--

CREATE TABLE `core_user` (
  `id` int(11) NOT NULL,
  `active_role_id` smallint(5) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(150) NOT NULL,
  `mail` varchar(60) NOT NULL DEFAULT '',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1: passive; 2: active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_user`
--

INSERT INTO `core_user` (`id`, `active_role_id`, `username`, `password`, `mail`, `status`) VALUES
(0, 2, 'anonymous', '', '', 2),
(1, 1, 'admin', '[replacePassword]', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `core_user_role`
--

CREATE TABLE `core_user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `core_user_role`
--

INSERT INTO `core_user_role` (`user_id`, `role_id`) VALUES
(1, 1),
(0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mod_form_field`
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
-- Dumping data for table `mod_form_field`
--

INSERT INTO `mod_form_field` (`id`, `module`, `event`, `field_name`, `visibility`, `required`, `field_order`, `default_value`) VALUES
(18, 'User', 'signUpEvent', 'username', 'visible', 'true', -110, ''),
(19, 'User', 'signUpEvent', 'password', 'visible', 'true', -100, ''),
(20, 'User', 'signUpEvent', 'password2', 'visible', 'true', -90, ''),
(21, 'User', 'signUpEvent', 'firstName', 'visible', 'true', -80, ''),
(22, 'User', 'signUpEvent', 'middleNames', 'visible', 'false', -70, ''),
(23, 'User', 'signUpEvent', 'lastName', 'visible', 'true', -60, ''),
(24, 'User', 'signUpEvent', 'company', 'visible', 'false', -50, ''),
(25, 'User', 'signUpEvent', 'email', 'visible', 'true', -40, ''),
(26, 'User', 'signUpEvent', 'phone1', 'visible', 'false', -30, ''),
(27, 'User', 'signUpEvent', 'phone2', 'visible', 'false', -20, ''),
(28, 'User', 'signUpEvent', 'country', 'visible', 'false', -10, ''),
(29, 'User', 'signUpEvent', 'postalAddress', 'visible', 'false', 0, ''),
(30, 'User', 'signUpEvent', 'addressLine1', 'visible', 'false', 10, ''),
(31, 'User', 'signUpEvent', 'addressLine2', 'visible', 'false', 20, ''),
(32, 'User', 'signUpEvent', 'addressLine3', 'visible', 'false', 30, ''),
(33, 'User', 'signUpEvent', 'addressLine4', 'visible', 'false', 40, ''),
(34, 'User', 'signUpEvent', 'postCode', 'visible', 'false', 50, ''),
(35, 'User', 'signUpEvent', 'comment', 'visible', 'false', 60, ''),
(36, 'User', 'signUpEvent', 'agreement', 'visible', 'true', 70, ''),
(37, 'User', 'xPostalAddressEvent', 'country', 'visible', 'false', 10, 'XX'),
(38, 'User', 'xPostalAddressEvent', 'postalAddress', 'visible', 'false', 20, ''),
(39, 'User', 'xPostalAddressEvent', 'addressLine1', 'visible', 'false', 30, ''),
(40, 'User', 'xPostalAddressEvent', 'addressLine2', 'visible', 'false', 40, ''),
(41, 'User', 'xPostalAddressEvent', 'addressLine3', 'visible', 'false', 50, ''),
(42, 'User', 'xPostalAddressEvent', 'addressLine4', 'visible', 'false', 60, ''),
(43, 'User', 'xPostalAddressEvent', 'postCode', 'visible', 'false', 70, ''),
(44, 'User', 'xPostalAddressEvent', 'comment', 'visible', 'false', 80, ''),
(45, 'User', 'xPostalAddressEvent', 'title', 'visible', 'false', 90, ''),
(46, 'User', 'xAccountEvent', 'username', 'visible', 'false', 10, ''),
(47, 'User', 'xAccountEvent', 'password', 'visible', 'true', 95, ''),
(48, 'User', 'xAccountEvent', 'emailId', 'visible', 'false', 30, '0'),
(49, 'User', 'xAccountEvent', 'firstName', 'visible', 'false', 40, ''),
(50, 'User', 'xAccountEvent', 'middleNames', 'visible', 'false', 50, ''),
(51, 'User', 'xAccountEvent', 'lastName', 'visible', 'false', 60, ''),
(52, 'User', 'xAccountEvent', 'company', 'visible', 'false', 70, ''),
(53, 'User', 'xAccountEvent', 'phone1', 'visible', 'false', 80, ''),
(54, 'User', 'xAccountEvent', 'phone2', 'visible', 'false', 90, ''),
(55, 'User', 'xAccountEvent', 'password2', 'visible', 'true', 100, ''),
(56, 'User', 'xAccountEvent', 'passwordStatus', 'visible', 'false', 110, ''),
(57, 'User', 'editContactFormEvent', 'contactName', 'visible', 'false', 10, ''),
(58, 'User', 'editContactFormEvent', 'emailId', 'visible', 'false', 20, '0'),
(59, 'User', 'editContactFormEvent', 'description', 'visible', 'false', 30, ''),
(60, 'User', 'editContactFormEvent', 'status', 'visible', 'false', 40, 'active'),
(61, 'User', 'contactFormEvent', 'senderName', 'visible', 'false', 10, ''),
(62, 'User', 'contactFormEvent', 'senderEmail', 'hidden', 'false', 20, ''),
(63, 'User', 'editContactFormEvent', 'message', 'hidden', 'false', 10, ''),
(64, 'User', 'editContactFormEvent', 'subject', 'hidden', 'false', 20, ''),
(65, 'User', 'editContactFormEvent', 'userId', 'hidden', 'false', 30, '1'),
(66, 'User', 'addContactFormEvent', 'contactName', 'visible', 'false', 10, ''),
(67, 'User', 'addContactFormEvent', 'emailId', 'visible', 'false', 20, '0'),
(68, 'User', 'addContactFormEvent', 'description', 'visible', 'false', 30, ''),
(69, 'User', 'addContactFormEvent', 'status', 'visible', 'false', 40, 'active');

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

--
-- Dumping data for table `mod_global_observer_event`
--

INSERT INTO `mod_global_observer_event` (`id`, `visitor_id`, `location_id`, `user_id`, `type`, `timestamp`) VALUES
(6, 2, 4, 0, 1, 1554513229),
(7, 2, 4, 0, 11, 1554513236),
(8, 2, 4, 0, 1, 1554513247);

-- --------------------------------------------------------

--
-- Table structure for table `mod_global_observer_location`
--

CREATE TABLE `mod_global_observer_location` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mod_global_observer_location`
--

INSERT INTO `mod_global_observer_location` (`id`, `value`) VALUES
(1, 'http://localhost/a-cms/amc-ce1/'),
(2, 'http://localhost/a-cms/amc-ce1/app-user/login'),
(3, 'http://localhost/a-cms/amc-ce1/app-user'),
(4, 'http://localhost/a-cms/allmice-cms-next-version/');

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
-- Table structure for table `mod_language`
--

CREATE TABLE `mod_language` (
  `id` tinyint(3) NOT NULL,
  `language_code` varchar(15) NOT NULL DEFAULT '' COMMENT 'Usually two digit ISO 639-1 Language Code for html tags.',
  `language_code2` varchar(15) NOT NULL DEFAULT '' COMMENT 'Other more specific language code to separate different language versions. E.g. IETF code en-GB for British English.',
  `label` varchar(60) NOT NULL DEFAULT 'English' COMMENT 'Language option as user sees it. E.g. Deutsch for German.',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'The status value determines, whether to show this language as option in drop-down menus or elsewhere. Possible values are 0 or 1, meaning passive (0) or active (1).',
  `direction` varchar(8) NOT NULL DEFAULT 'ltr' COMMENT 'Language writing direction. Possible values are ltr (default) and rtl meaning left to right and right to left correspondingly.',
  `date_format` varchar(15) NOT NULL DEFAULT 'd/m/Y' COMMENT 'Date format according to this language for the cases, if only date is needed to display, but not specific time (see also timeFormat). See http://php.net/manual/en/datetime.formats.date.php.',
  `time_format` varchar(30) NOT NULL DEFAULT 'd/m/Y H:i' COMMENT 'Time format according to this language (see also dateFormat). See http://php.net/manual/en/datetime.formats.date.php.',
  `number_format` varchar(15) NOT NULL DEFAULT '#2#.' COMMENT 'Number format for the language in form: thousandsSeparator#decimals#decimalPoint. Part decimals specifies how many decimals. Part decimalPoint specifies what string to use for decimal point. Part thousandsSeparator specifies what string to use for thousands separator. If this value is empty, then the default will be used ''#2#.''.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mod_language`
--

INSERT INTO `mod_language` (`id`, `language_code`, `language_code2`, `label`, `status`, `direction`, `date_format`, `time_format`, `number_format`) VALUES
(1, 'en', 'en', 'English', 1, 'ltr', 'Y-m-d', 'Y-m-dTH:i', '#2#.');

-- --------------------------------------------------------

--
-- Table structure for table `mod_language_item`
--

CREATE TABLE `mod_language_item` (
  `id` int(11) NOT NULL,
  `parent_item_id` int(11) NOT NULL DEFAULT '1',
  `child_item_id` int(11) NOT NULL DEFAULT '1',
  `module_name` varchar(30) NOT NULL DEFAULT 'Page',
  `type` varchar(30) NOT NULL DEFAULT 'page' COMMENT 'If a module has many db. tables with multilingual text, then type field helps to separate the tables (e.g.: menu and menu_item).',
  `path` varchar(60) NOT NULL DEFAULT 'page/view',
  `language_code` varchar(15) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

--
-- Dumping data for table `mod_menu`
--

INSERT INTO `mod_menu` (`id`, `code`, `title`, `type`, `status`, `creator_id`, `editor_id`) VALUES
(1, 'adminGeneralMenu', 'Admin General Menu', 21, 1, 1, 1),
(2, 'adminUserMenu', 'Admin User Menu', 21, 1, 1, 1),
(3, 'myAccount', 'My Account', 21, 2, 1, 1);

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
-- Dumping data for table `mod_menu_item`
--

INSERT INTO `mod_menu_item` (`id`, `menu_id`, `parent_id`, `label`, `uri`, `depth`, `weight`, `order_code`, `status`, `has_children`, `creator_id`, `editor_id`) VALUES
(1, 1, 0, 'Admin Misc', '/admin', 1, 1, '001', 1, 1, 1, 1),
(2, 1, 1, 'Add Alias', '/admin/add-alias', 2, 1, '001-008', 1, 0, 1, 1),
(3, 1, 1, 'Add Config', '/admin/add-config', 2, 2, '001-009', 1, 0, 1, 1),
(4, 1, 1, 'Add Role', '/admin/add-role', 2, 3, '001-010', 1, 0, 1, 1),
(5, 1, 1, 'List Aliases', '/admin/list-aliases', 2, 16, '001-011', 1, 0, 1, 1),
(6, 1, 1, 'List Config', '/admin/list-config', 2, 18, '001-013', 1, 0, 1, 1),
(7, 1, 1, 'List Roles', '/admin/list-roles', 2, 19, '001-014', 1, 0, 1, 1),
(8, 1, 0, 'Block', '/block', 1, 29, '002', 1, 1, 1, 1),
(9, 1, 8, 'Add', '/block/add', 2, 29, '002-015', 1, 0, 1, 1),
(10, 1, 8, 'List Blocks', '/block/list-blocks', 2, 33, '002-016', 1, 0, 1, 1),
(11, 1, 0, 'Menu', '/menu', 1, 34, '003', 1, 1, 1, 1),
(12, 1, 11, 'Add Menu', '/menu/add-menu', 2, 34, '003-017', 1, 0, 1, 1),
(13, 1, 11, 'Build Module Menu', '/menu/build-module-menu', 2, 36, '003-018', 1, 0, 1, 1),
(14, 1, 11, 'List Menu Items', '/menu/list-menu-items', 2, 42, '003-020', 1, 0, 1, 1),
(15, 1, 11, 'List Menus', '/menu/list-menus', 2, 43, '003-022', 1, 0, 1, 1),
(16, 1, 0, 'System Manager of Modules', '/system-manager', 1, 48, '006', 1, 1, 1, 1),
(17, 1, 16, 'Install Modules', '/system-manager/install-modules', 2, 48, '006-025', 1, 0, 1, 1),
(18, 1, 16, 'Install Module Structure', '/system-manager/install-module-structure', 2, 49, '006-026', 1, 0, 1, 1),
(19, 1, 16, 'Manage Access', '/system-manager/manage-access', 2, 51, '006-027', 1, 0, 1, 1),
(20, 1, 16, 'Uninstall Modules', '/system-manager/uninstall-modules', 2, 52, '006-028', 1, 0, 1, 1),
(21, 1, 16, 'Uninstall Module Structure', '/system-manager/uninstall-module-structure', 2, 53, '006-029', 1, 0, 1, 1),
(22, 2, 0, 'Message', '/message', 1, 51, '001', 1, 1, 1, 1),
(23, 2, 22, 'Add Template', '/message/add-template', 2, 51, '001-003', 1, 0, 1, 1),
(24, 2, 22, 'List All Messages', '/message/list-all-messages', 2, 59, '001-004', 1, 0, 1, 1),
(25, 2, 22, 'List Templates', '/message/list-templates', 2, 61, '001-005', 1, 0, 1, 1),
(26, 2, 0, 'User', '/user', 1, 101, '002', 1, 1, 1, 1),
(27, 2, 26, 'Add Account', '/user/add-account', 2, 101, '002-006', 1, 0, 1, 1),
(28, 2, 26, 'Add Any Contact Form', '/user/add-any-contact-form', 2, 102, '002-007', 1, 0, 1, 1),
(29, 2, 26, 'Add Any Email Address', '/user/add-any-email-address', 2, 103, '002-008', 1, 0, 1, 1),
(30, 2, 26, 'Add Any Postal Address', '/user/add-any-postal-address', 2, 104, '002-009', 1, 0, 1, 1),
(31, 2, 26, 'List Accounts', '/user/list-accounts', 2, 127, '002-010', 1, 0, 1, 1),
(32, 2, 26, 'List All Contact Forms', '/user/list-all-contact-forms', 2, 128, '002-011', 1, 0, 1, 1),
(33, 2, 26, 'List All Email Addresses', '/user/list-all-email-addresses', 2, 129, '002-012', 1, 0, 1, 1),
(34, 2, 26, 'List All Postal Addresses', '/user/list-all-postal-addresses', 2, 130, '002-013', 1, 0, 1, 1),
(35, 3, 0, 'Account Details', '/user/my-account-options', 1, 130, '003', 1, 1, 1, 1),
(36, 3, 35, 'Add Contact Form', '/user/add-contact-form', 2, 5, '003-004', 1, 0, 1, 1),
(37, 3, 35, 'Add Email Address', '/user/add-email-address', 2, 6, '003-005', 1, 0, 1, 1),
(38, 3, 35, 'Add Postal Address', '/user/add-postal-address', 2, 7, '003-006', 1, 0, 1, 1),
(39, 3, 35, 'List Contact Forms', '/user/list-contact-forms', 2, 31, '003-007', 1, 0, 1, 1),
(40, 3, 35, 'List Email Addresses', '/user/list-email-addresses', 2, 32, '003-008', 1, 0, 1, 1),
(41, 3, 35, 'List Postal Addresses', '/user/list-postal-addresses', 2, 33, '003-009', 1, 0, 1, 1),
(42, 3, 35, 'Log Out', '/user/logout', 2, 36, '003-010', 1, 0, 1, 1),
(43, 3, 0, 'Messages', '/message/list-messages', 1, 110, '001', 1, 0, 1, 1),
(44, 3, 0, 'Profile', '/profile', 1, 120, '002', 1, 0, 1, 1),
(45, 1, 1, 'List Bot Access Resources', '/admin/list-bot-access-resources', 2, 17, '001-012', 1, 0, 1, 1),
(46, 1, 0, 'Theme', '/theme', 1, 60, '007', 1, 1, 1, 1),
(47, 1, 46, 'Choose Default Theme', '/theme/choose-default-theme', 2, 61, '007-030', 1, 0, 1, 1),
(48, 1, 46, 'Install Themes', '/theme/install-themes', 2, 62, '007-031', 1, 0, 1, 1),
(49, 1, 46, 'Uninstall Themes', '/theme/uninstall-themes', 2, 64, '007-032', 1, 0, 1, 1),
(50, 1, 0, 'Search', '/search', 1, 45, '005', 1, 1, 1, 1),
(51, 1, 50, 'Add Type', '/search/add-type', 2, 46, '005-023', 1, 0, 1, 1),
(52, 1, 50, 'List Types', '/search/list-types', 2, 47, '005-024', 1, 0, 1, 1),
(53, 1, 0, 'Page', '/page', 1, 40, '004', 1, 1, 1, 1),
(54, 1, 53, 'Add Page', '/page/add-page', 2, 41, '004-019', 1, 0, 1, 1),
(55, 1, 53, 'List All Pages', '/page/list-all-pages', 2, 42, '004-021', 1, 0, 1, 1);

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
-- Dumping data for table `mod_message_template`
--

INSERT INTO `mod_message_template` (`id`, `code`, `subject`, `module`, `type`, `content_html`, `content_plain`, `language_code`) VALUES
(0, 'wrapperUser', 'Member [memberName] of [websiteName]: [messageSubject]', 'Message', 'wrapper', 'Before reply, please read the note at the end of this email!\r\nThis is a message from the member [memberName] of [websiteName], who sent it to you through this website.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Log in to the website instead and use the reply link of this message in the list of your messages, which you can find on [listMessages].\r\nIf you wish to avoid such user messages in the future, then you can add message blockings to users on [addUserBlocking].', 'Before reply, please read the note at the end of this email!\r\nThis is a message from the member [memberName] of [websiteName], who sent it to you through this website.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Log in to the website instead and use the reply link of this message in the list of your messages, which you can find on [listMessages].\r\nIf you wish to avoid such user messages in the future, then you can add message blockings to users on [addUserBlocking].', 'en'),
(1, 'wrapperGuest', 'Guest [guestName] of website [websiteName]: [messageSubject]', 'User', 'wrapper', 'Before reply, please read the note at the end of this email!\r\nThis is a message from the guest [guestName] ([guestEmail]) of website [websiteName], who sent it to you through your account&amp;#39;s contact form on this website.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Try to use the email address instead, which the guest added by sending this message, which is: [guestEmail].\r\nIf you wish to avoid such guest messages in the future, then you can disable your contact form from guests on [editContactForm]/[myContactId].', 'Before reply, please read the note at the end of this email!\r\nThis is a message from the guest [guestName] (guestEmail) of [websiteName], who sent it to you through your account&amp;#39;s contact form on this website.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Try to use the email address instead, which the guest added by sending this message, which is: [guestEmail].\r\nIf you wish to avoid such guest messages in the future, then you can disable your contact form from guests on [editContactForm]/[myContactId].', 'en'),
(2, 'wrapperMember', 'Member [memberName] of website [websiteName]: [messageSubject]', 'User', 'wrapper', 'Before reply, please read the note at the end of this email!\r\nThis is a message from the member [memberName] of website [websiteName], who sent it to you through your account&amp;#39;s contact form on this website.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Log in to the website instead and use the contact form of this member, which you can find on [contactForm]/[memberContactId].\r\nIf you wish to avoid such guest messages in the future, then you can disable your contact form from members on [editContactForm]/[myContactId].', 'Before reply, please read the note at the end of this email!\r\nThis is a message from the member [memberName] of [websiteName], who sent it to you through your account&amp;#39;s contact form on this website.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Log in to the website instead and reply to the message in the list of your messages, which you can find on [baseUrl]/message/list-messages.', 'en'),
(3, 'wrapperSystem', 'System message from website [websiteName]: [messageSubject]', 'User', 'wrapper', 'Before reply, please read the note at the end of this email!\r\nThis is an automated message from the [websiteName] about your account.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Log in to the website instead and use the contact form of the administrator, which you can find on [adminContactForm].', 'Before reply, please read the note at the end of this email!\r\nThis is an automated message from the [websiteName] about your account.\r\n--------------- Start of message content ---------------\r\n[messageContent]\r\n---------------- End of message content ----------------\r\nNote: If you wish to reply to this message, then please don&amp;#39;t use [websiteName]&amp;#39;s email address, where this message came from. Log in to the website instead and use the contact form of the administrator, which you can find on [adminContactForm].', 'en'),
(4, 'verifyEmail', 'System message from website [websiteName]: Verifying your email for account [username]', 'User', 'userAccount', 'This is an automated message from the website [websiteName] ([baseUrl]).\r\n\r\n--------------- Start of message content ---------------\r\n\r\nSomebody (possibly you) has added this email address to his/her account [username] on [websiteName].\r\nIf it was you, then please click the following link (or copy it into your browser) to activate your email address for your account on [websiteName].\r\n\r\nEmail activation link is: [activationLink]\r\n\r\nIf you didn&amp;#39;t initiate the request, then you don&amp;#39;t need to take any further action. You can simply disregard the verification email and the email won&amp;#39;t be verified.\r\nIf these email verification messages are repeating and you are not initiating these email activations for your account on  website [websiteName], then you can contact us about this issue using the link: [contactLink].\r\n\r\n---------------- End of message content ----------------', 'This is an automated message from the website [websiteName] ([baseUrl]).\r\n\r\n--------------- Start of message content ---------------\r\n\r\nSomebody (possibly you) has added this email address to his/her account [username] on [websiteName].\r\nIf it was you, then please click the following link (or copy it into your browser) to activate your email address for your account on [websiteName].\r\n\r\nEmail activation link is: [activationLink]\r\n\r\nIf you didn&amp;#39;t initiate the request, then you don&amp;#39;t need to take any further action. You can simply disregard the verification email and the email won&amp;#39;t be verified.\r\nIf these email verification messages are repeating and you are not initiating these email activations for your account on  website [websiteName], then you can contact us about this issue using the link: [contactLink].\r\n\r\n---------------- End of message content ----------------', 'en'),
(5, 'recoverAccount', 'System message from website [websiteName]: New password for account [username]', 'User', 'userAccount', 'This is an automated message from the website [websiteName] ([baseUrl]).\r\n\r\n--------------- Start of message content ---------------\r\n\r\nSomebody (possibly you) has requested a new password for the account [username] on [websiteName].\r\n\r\nThe new password is: [password]\r\n\r\nIt is suggested, that you log in with your new password and change it as soon as possible on address [profileLink].\r\nIf you didn&amp;#39;t initiate this request, then it is suggested, that you submit after logging in a memorable word for your email on [emailLink].\r\nIf you have questions about this email, then you can contact us using the link: [contactLink].\r\n\r\n---------------- End of message content ----------------', 'This is an automated message from the website [websiteName] ([baseUrl]).\r\n\r\n--------------- Start of message content ---------------\r\n\r\nSomebody (possibly you) has requested a new password for the account [username] on [websiteName].\r\n\r\nThe new password is: [password]\r\n\r\nIt is suggested, that you log in with your new password and change it as soon as possible on address [profileLink].\r\nIf you didn&amp;#39;t initiate this request, then it is suggested, that you submit after logging in a memorable word for your email on [emailLink].\r\nIf you have questions about this email, then you can contact us using the link: [contactLink].\r\n\r\n---------------- End of message content ----------------', 'en');

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
-- Dumping data for table `mod_page`
--

INSERT INTO `mod_page` (`id`, `title`, `description`, `body`, `status`, `created`, `edited`, `creator_id`, `editor_id`) VALUES
(1, 'Front page', '', '<p>Welcome!<br />This is default front page content.</p>\r\n', 2, 1558451627, 1558451627, 1, 1);

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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
-- Dumping data for table `mod_search`
--

INSERT INTO `mod_search` (`id`, `title`, `description`, `search_table_field`, `search_table`, `module_name`, `uri`, `title_table_field`, `add_where_clause`, `result_field_names`, `result_field_titles`, `language_code`) VALUES
(1, 'Page body area', 'Search from page body area', 'body', '', 'Page', '/page/view', 'title', '', 'id, title, [result:]body', '[skip], Title, Start of search result ...', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `mod_user`
--

CREATE TABLE `mod_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `first_name` varchar(120) NOT NULL DEFAULT '',
  `middle_names` varchar(250) NOT NULL DEFAULT '',
  `last_name` varchar(120) NOT NULL DEFAULT '',
  `company` varchar(120) NOT NULL DEFAULT '',
  `phone1` varchar(30) NOT NULL DEFAULT '',
  `phone2` varchar(30) NOT NULL DEFAULT '',
  `language_code` varchar(15) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mod_user`
--

INSERT INTO `mod_user` (`id`, `user_id`, `first_name`, `middle_names`, `last_name`, `company`, `phone1`, `phone2`, `language_code`) VALUES
(1, 1, '', '', '', '', '', '', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `mod_user_contact`
--

CREATE TABLE `mod_user_contact` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `email_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL DEFAULT '',
  `description` varchar(2000) NOT NULL DEFAULT '',
  `status` varchar(60) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mod_user_country`
--

CREATE TABLE `mod_user_country` (
  `id` int(11) NOT NULL,
  `name_short` varchar(60) NOT NULL DEFAULT '',
  `code` varchar(15) NOT NULL DEFAULT '',
  `name_long` varchar(125) NOT NULL DEFAULT '',
  `language_code` varchar(15) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mod_user_country`
--

INSERT INTO `mod_user_country` (`id`, `name_short`, `code`, `name_long`, `language_code`) VALUES
(1, 'Afghanistan', 'AF', 'Islamic Republic of Afghanistan', 'en'),
(2, 'Albania', 'AL', 'Republic of Albania', 'en'),
(3, 'Algeria', 'DZ', 'People\'s Democratic Republic of Algeria', 'en'),
(4, 'Andorra', 'AD', 'Principality of Andorra', 'en'),
(5, 'Angola', 'AO', 'Republic of Angola', 'en'),
(6, 'Antigua and Barbuda', 'AG', '(no long-form name)', 'en'),
(7, 'Argentina', 'AR', 'Argentine Republic', 'en'),
(8, 'Armenia', 'AM', 'Republic of Armenia', 'en'),
(9, 'Australia', 'AU', 'Commonwealth of Australia', 'en'),
(10, 'Austria', 'AT', 'Republic of Austria', 'en'),
(11, 'Azerbaijan', 'AZ', 'Republic of Azerbaijan', 'en'),
(12, 'Bahamas, The', 'BS', 'Commonwealth of The Bahamas', 'en'),
(13, 'Bahrain', 'BH', 'Kingdom of Bahrain', 'en'),
(14, 'Bangladesh', 'BD', 'People\'s Republic of Bangladesh', 'en'),
(15, 'Barbados', 'BB', '(no long-form name)', 'en'),
(16, 'Belarus', 'BY', 'Republic of Belarus', 'en'),
(17, 'Belgium', 'BE', 'Kingdom of Belgium', 'en'),
(18, 'Belize', 'BZ', '(no long-form name)', 'en'),
(19, 'Benin', 'BJ', 'Republic of Benin', 'en'),
(20, 'Bhutan', 'BT', 'Kingdom of Bhutan', 'en'),
(21, 'Bolivia', 'BO', 'Plurinational State of Bolivia', 'en'),
(22, 'Bosnia and Herzegovina', 'BA', '(no long-form name)', 'en'),
(23, 'Botswana', 'BW', 'Republic of Botswana', 'en'),
(24, 'Brazil', 'BR', 'Federative Republic of Brazil', 'en'),
(25, 'Brunei', 'BN', 'Brunei Darussalam', 'en'),
(26, 'Bulgaria', 'BG', 'Republic of Bulgaria', 'en'),
(27, 'Burkina Faso', 'BF', 'Burkina Faso', 'en'),
(28, 'Burma', 'MM', 'Union of Burma [Myanmar]', 'en'),
(29, 'Burundi', 'BI', 'Republic of Burundi', 'en'),
(30, 'Cambodia', 'KH', 'Kingdom of Cambodia', 'en'),
(31, 'Cameroon', 'CM', 'Republic of Cameroon', 'en'),
(32, 'Canada', 'CA', '(no long-form name)', 'en'),
(33, 'Cape Verde', 'CV', 'Republic of Cape Verde', 'en'),
(34, 'Central African Republic', 'CF', 'Central African Republic', 'en'),
(35, 'Chad', 'TD', 'Republic of Chad', 'en'),
(36, 'Chile', 'CL', 'Republic of Chile', 'en'),
(37, 'China', 'CN', 'People\'s Republic of China', 'en'),
(38, 'Colombia', 'CO', 'Republic of Colombia', 'en'),
(39, 'Comoros', 'KM', 'Union of the Comoros', 'en'),
(40, 'Congo (Brazzaville)', 'CG', 'Republic of the Congo', 'en'),
(41, 'Congo (Kinshasa)', 'CD', 'Democratic Republic of the Congo', 'en'),
(42, 'Costa Rica', 'CR', 'Republic of Costa Rica', 'en'),
(43, 'Côte d\'Ivoire (Ivory Coast)', 'CI', 'Republic of Côte d\'Ivoire [Ivory Coast]', 'en'),
(44, 'Croatia', 'HR', 'Republic of Croatia', 'en'),
(45, 'Cuba', 'CU', 'Republic of Cuba', 'en'),
(46, 'Cyprus', 'CY', 'Republic of Cyprus', 'en'),
(47, 'Czech Republic', 'CZ', 'Czech Republic', 'en'),
(48, 'Denmark', 'DK', 'Kingdom of Denmark', 'en'),
(49, 'Djibouti', 'DJ', 'Republic of Djibouti', 'en'),
(50, 'Dominica', 'DM', 'Commonwealth of Dominica', 'en'),
(51, 'Dominican Republic', 'DO', 'Dominican Republic', 'en'),
(52, 'Ecuador', 'EC', 'Republic of Ecuador', 'en'),
(53, 'Egypt', 'EG', 'Arab Republic of Egypt', 'en'),
(54, 'El Salvador', 'SV', 'Republic of El Salvador', 'en'),
(55, 'Equatorial Guinea', 'GQ', 'Republic of Equatorial Guinea', 'en'),
(56, 'Eritrea', 'ER', 'State of Eritrea', 'en'),
(57, 'Estonia', 'EE', 'Republic of Estonia', 'en'),
(58, 'Ethiopia', 'ET', 'Federal Democratic Republic of Ethiopia', 'en'),
(59, 'Fiji', 'FJ', 'Republic of Fiji', 'en'),
(60, 'Finland', 'FI', 'Republic of Finland', 'en'),
(61, 'France', 'FR', 'French Republic', 'en'),
(62, 'Gabon', 'GA', 'Gabonese Republic', 'en'),
(63, 'Gambia, The', 'GM', 'Republic of The Gambia', 'en'),
(64, 'Georgia', 'GE', 'Georgia', 'en'),
(65, 'Germany', 'DE', 'Federal Republic of Germany', 'en'),
(66, 'Ghana', 'GH', 'Republic of Ghana', 'en'),
(67, 'Greece', 'GR', 'Hellenic Republic', 'en'),
(68, 'Grenada', 'GD', '(no long-form name)', 'en'),
(69, 'Guatemala', 'GT', 'Republic of Guatemala', 'en'),
(70, 'Guinea', 'GN', 'Republic of Guinea', 'en'),
(71, 'Guinea-Bissau', 'GW', 'Republic of Guinea-Bissau', 'en'),
(72, 'Guyana', 'GY', 'Co-operative Republic of Guyana', 'en'),
(73, 'Haiti', 'HT', 'Republic of Haiti', 'en'),
(74, 'Holy See (Vatican City)', 'VA', 'Holy See [Vatican City]', 'en'),
(75, 'Honduras', 'HN', 'Republic of Honduras', 'en'),
(76, 'Hungary', 'HU', '! Hungary', 'en'),
(77, 'Iceland', 'IS', 'Republic of Iceland', 'en'),
(78, 'India', 'IN', 'Republic of India', 'en'),
(79, 'Indonesia', 'ID', 'Republic of Indonesia', 'en'),
(80, 'Iran', 'IR', 'Islamic Republic of Iran', 'en'),
(81, 'Iraq', 'IQ', 'Republic of Iraq', 'en'),
(82, 'Ireland', 'IE', '(no long-form name)', 'en'),
(83, 'Israel', 'IL', 'State of Israel', 'en'),
(84, 'Italy', 'IT', 'Italian Republic', 'en'),
(85, 'Jamaica', 'JM', '(no long-form name)', 'en'),
(86, 'Japan', 'JP', '(no long-form name)', 'en'),
(87, 'Jordan', 'JO', 'Hashemite Kingdom of Jordan', 'en'),
(88, 'Kazakhstan', 'KZ', 'Republic of Kazakhstan', 'en'),
(89, 'Kenya', 'KE', 'Republic of Kenya', 'en'),
(90, 'Kiribati', 'KI', 'Republic of Kiribati', 'en'),
(91, 'Korea, North', 'KP', 'Democratic People\'s Republic of Korea', 'en'),
(92, 'Korea, South', 'KR', 'Republic of Korea', 'en'),
(93, 'Kosovo', 'XK', 'Republic of Kosovo', 'en'),
(94, 'Kuwait', 'KW', 'State of Kuwait', 'en'),
(95, 'Kyrgyzstan', 'KG', 'Kyrgyz Republic', 'en'),
(96, 'Laos', 'LA', 'Lao People\'s Democratic Republic', 'en'),
(97, 'Latvia', 'LV', 'Republic of Latvia', 'en'),
(98, 'Lebanon', 'LB', 'Lebanese Republic', 'en'),
(99, 'Lesotho', 'LS', 'Kingdom of Lesotho', 'en'),
(100, 'Liberia', 'LR', 'Republic of Liberia', 'en'),
(101, 'Libya', 'LY', 'Libya', 'en'),
(102, 'Liechtenstein', 'LI', 'Principality of Liechtenstein', 'en'),
(103, 'Lithuania', 'LT', 'Republic of Lithuania', 'en'),
(104, 'Luxembourg', 'LU', 'Grand Duchy of Luxembourg', 'en'),
(105, 'Macedonia', 'MK', 'Republic of Macedonia [Macedonia, The Former Yugoslav Republic of]', 'en'),
(106, 'Madagascar', 'MG', 'Republic of Madagascar', 'en'),
(107, 'Malawi', 'MW', 'Republic of Malawi', 'en'),
(108, 'Malaysia', 'MY', '(no long-form name)', 'en'),
(109, 'Maldives', 'MV', 'Republic of Maldives', 'en'),
(110, 'Mali', 'ML', 'Republic of Mali', 'en'),
(111, 'Malta', 'MT', 'Republic of Malta', 'en'),
(112, 'Marshall Islands', 'MH', 'Republic of the Marshall Islands', 'en'),
(113, 'Mauritania', 'MR', 'Islamic Republic of Mauritania', 'en'),
(114, 'Mauritius', 'MU', 'Republic of Mauritius', 'en'),
(115, 'Mexico', 'MX', 'United Mexican States', 'en'),
(116, 'Micronesia, Federated States of', 'FM', 'Federated States of Micronesia', 'en'),
(117, 'Moldova', 'MD', 'Republic of Moldova', 'en'),
(118, 'Monaco', 'MC', 'Principality of Monaco', 'en'),
(119, 'Mongolia', 'MN', '(no long-form name)', 'en'),
(120, 'Montenegro', 'ME', 'Montenegro', 'en'),
(121, 'Morocco', 'MA', 'Kingdom of Morocco', 'en'),
(122, 'Mozambique', 'MZ', 'Republic of Mozambique', 'en'),
(123, 'Namibia', 'NA', 'Republic of Namibia', 'en'),
(124, 'Nauru', 'NR', 'Republic of Nauru', 'en'),
(125, 'Nepal', 'NP', 'Federal Democratic Republic of Nepal', 'en'),
(126, 'Netherlands', 'NL', 'Kingdom of the Netherlands', 'en'),
(127, 'New Zealand', 'NZ', '(no long-form name)', 'en'),
(128, 'Nicaragua', 'NI', 'Republic of Nicaragua', 'en'),
(129, 'Niger', 'NE', 'Republic of Niger', 'en'),
(130, 'Nigeria', 'NG', 'Federal Republic of Nigeria', 'en'),
(131, 'Norway', 'NO', 'Kingdom of Norway', 'en'),
(132, 'Oman', 'OM', 'Sultanate of Oman', 'en'),
(133, 'Pakistan', 'PK', 'Islamic Republic of Pakistan', 'en'),
(134, 'Palau', 'PW', 'Republic of Palau', 'en'),
(135, 'Panama', 'PA', 'Republic of Panama', 'en'),
(136, 'Papua New Guinea', 'PG', 'Independent State of Papua New Guinea', 'en'),
(137, 'Paraguay', 'PY', 'Republic of Paraguay', 'en'),
(138, 'Peru', 'PE', 'Republic of Peru', 'en'),
(139, 'Philippines', 'PH', 'Republic of the Philippines', 'en'),
(140, 'Poland', 'PL', 'Republic of Poland', 'en'),
(141, 'Portugal', 'PT', 'Portuguese Republic', 'en'),
(142, 'Qatar', 'QA', 'State of Qatar', 'en'),
(143, 'Romania', 'RO', '(no long-form name)', 'en'),
(144, 'Russia', 'RU', 'Russian Federation', 'en'),
(145, 'Rwanda', 'RW', 'Republic of Rwanda', 'en'),
(146, 'Saint Kitts and Nevis', 'KN', 'Federation of Saint Kitts and Nevis', 'en'),
(147, 'Saint Lucia', 'LC', '(no long-form name)', 'en'),
(148, 'Saint Vincent and the Grenadines', 'VC', '(no long-form name)', 'en'),
(149, 'Samoa', 'WS', 'Independent State of Samoa', 'en'),
(150, 'San Marino', 'SM', 'Republic of San Marino', 'en'),
(151, 'Sao Tome and Principe', 'ST', 'Democratic Republic of Sao Tome and Principe', 'en'),
(152, 'Saudi Arabia', 'SA', 'Kingdom of Saudi Arabia', 'en'),
(153, 'Senegal', 'SN', 'Republic of Senegal', 'en'),
(154, 'Serbia', 'RS', 'Republic of Serbia', 'en'),
(155, 'Seychelles', 'SC', 'Republic of Seychelles', 'en'),
(156, 'Sierra Leone', 'SL', 'Republic of Sierra Leone', 'en'),
(157, 'Singapore', 'SG', 'Republic of Singapore', 'en'),
(158, 'Slovakia', 'SK', 'Slovak Republic', 'en'),
(159, 'Slovenia', 'SI', 'Republic of Slovenia', 'en'),
(160, 'Solomon Islands', 'SB', '(no long-form name)', 'en'),
(161, 'Somalia', 'SO', '(no long-form name)', 'en'),
(162, 'South Africa', 'ZA', 'Republic of South Africa', 'en'),
(163, 'South Sudan', 'SS', 'Republic of South Sudan', 'en'),
(164, 'Spain', 'ES', 'Kingdom of Spain', 'en'),
(165, 'Sri Lanka', 'LK', 'Democratic Socialist Republic of Sri Lanka', 'en'),
(166, 'Sudan', 'SD', 'Republic of the Sudan', 'en'),
(167, 'Suriname', 'SR', 'Republic of Suriname', 'en'),
(168, 'Swaziland', 'SZ', 'Kingdom of Swaziland', 'en'),
(169, 'Sweden', 'SE', 'Kingdom of Sweden', 'en'),
(170, 'Switzerland', 'CH', 'Swiss Confederation', 'en'),
(171, 'Syria', 'SY', 'Syrian Arab Republic', 'en'),
(172, 'Tajikistan', 'TJ', 'Republic of Tajikistan', 'en'),
(173, 'Tanzania', 'TZ', 'United Republic of Tanzania', 'en'),
(174, 'Thailand', 'TH', 'Kingdom of Thailand', 'en'),
(175, 'Timor-Leste', 'TL', 'Democratic Republic of Timor-Leste', 'en'),
(176, 'Togo', 'TG', 'Togolese Republic', 'en'),
(177, 'Tonga', 'TO', 'Kingdom of Tonga', 'en'),
(178, 'Trinidad and Tobago', 'TT', 'Republic of Trinidad and Tobago', 'en'),
(179, 'Tunisia', 'TN', 'Tunisian Republic', 'en'),
(180, 'Turkey', 'TR', 'Republic of Turkey', 'en'),
(181, 'Turkmenistan', 'TM', '(no long-form name)', 'en'),
(182, 'Tuvalu', 'TV', '(no long-form name)', 'en'),
(183, 'Uganda', 'UG', 'Republic of Uganda', 'en'),
(184, 'Ukraine', 'UA', '(no long-form name)', 'en'),
(185, 'United Arab Emirates', 'AE', 'United Arab Emirates', 'en'),
(186, 'United Kingdom', 'GB', 'United Kingdom of Great Britain and Northern Ireland', 'en'),
(187, 'United States', 'US', 'United States of America', 'en'),
(188, 'Uruguay', 'UY', 'Oriental Republic of Uruguay', 'en'),
(189, 'Uzbekistan', 'UZ', 'Republic of Uzbekistan', 'en'),
(190, 'Vanuatu', 'VU', 'Republic of Vanuatu', 'en'),
(191, 'Venezuela', 'VE', 'Bolivarian Republic of Venezuela', 'en'),
(192, 'Vietnam', 'VN', 'Socialist Republic of Vietnam', 'en'),
(193, 'Yemen', 'YE', 'Republic of Yemen', 'en'),
(194, 'Zambia', 'ZM', 'Republic of Zambia', 'en'),
(195, 'Zimbabwe', 'ZW', 'Republic of Zimbabwe', 'en'),
(196, 'Other', 'XX', 'Country not determined', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `mod_user_email`
--

CREATE TABLE `mod_user_email` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `email_address` varchar(120) NOT NULL DEFAULT '',
  `mem_word_question` varchar(250) NOT NULL DEFAULT '',
  `mem_word` varchar(60) NOT NULL DEFAULT '',
  `verifying_code` varchar(250) NOT NULL DEFAULT '',
  `status` varchar(30) NOT NULL DEFAULT '',
  `comment` varchar(2000) NOT NULL DEFAULT '',
  `change_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mod_user_postal`
--

CREATE TABLE `mod_user_postal` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `country_code` varchar(15) NOT NULL DEFAULT '',
  `postal_address` varchar(2000) NOT NULL DEFAULT '',
  `address_line1` varchar(250) NOT NULL DEFAULT '',
  `address_line2` varchar(250) NOT NULL DEFAULT '',
  `address_line3` varchar(250) NOT NULL DEFAULT '',
  `address_line4` varchar(250) NOT NULL DEFAULT '',
  `post_code` varchar(15) NOT NULL DEFAULT '',
  `comment` varchar(2000) NOT NULL DEFAULT '',
  `title` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `core_access`
--
ALTER TABLE `core_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_alias`
--
ALTER TABLE `core_alias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_block`
--
ALTER TABLE `core_block`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_caching`
--
ALTER TABLE `core_caching`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_config`
--
ALTER TABLE `core_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_language`
--
ALTER TABLE `core_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_misc_data`
--
ALTER TABLE `core_misc_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_module`
--
ALTER TABLE `core_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_resource`
--
ALTER TABLE `core_resource`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_role`
--
ALTER TABLE `core_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_session`
--
ALTER TABLE `core_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_theme`
--
ALTER TABLE `core_theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_user`
--
ALTER TABLE `core_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_form_field`
--
ALTER TABLE `mod_form_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_global_observer_event`
--
ALTER TABLE `mod_global_observer_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_global_observer_location`
--
ALTER TABLE `mod_global_observer_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_global_observer_visitor`
--
ALTER TABLE `mod_global_observer_visitor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_language`
--
ALTER TABLE `mod_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_language_item`
--
ALTER TABLE `mod_language_item`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `mod_search`
--
ALTER TABLE `mod_search`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_user`
--
ALTER TABLE `mod_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_user_contact`
--
ALTER TABLE `mod_user_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_user_country`
--
ALTER TABLE `mod_user_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_user_email`
--
ALTER TABLE `mod_user_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mod_user_postal`
--
ALTER TABLE `mod_user_postal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `core_access`
--
ALTER TABLE `core_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=571;

--
-- AUTO_INCREMENT for table `core_alias`
--
ALTER TABLE `core_alias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_block`
--
ALTER TABLE `core_block`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `core_caching`
--
ALTER TABLE `core_caching`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_config`
--
ALTER TABLE `core_config`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `core_language`
--
ALTER TABLE `core_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1502;

--
-- AUTO_INCREMENT for table `core_misc_data`
--
ALTER TABLE `core_misc_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `core_module`
--
ALTER TABLE `core_module`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `core_resource`
--
ALTER TABLE `core_resource`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `core_role`
--
ALTER TABLE `core_role`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `core_theme`
--
ALTER TABLE `core_theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `core_user`
--
ALTER TABLE `core_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mod_form_field`
--
ALTER TABLE `mod_form_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `mod_global_observer_event`
--
ALTER TABLE `mod_global_observer_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mod_global_observer_location`
--
ALTER TABLE `mod_global_observer_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mod_global_observer_visitor`
--
ALTER TABLE `mod_global_observer_visitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mod_language`
--
ALTER TABLE `mod_language`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mod_language_item`
--
ALTER TABLE `mod_language_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mod_menu`
--
ALTER TABLE `mod_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mod_menu_item`
--
ALTER TABLE `mod_menu_item`
  MODIFY `id` mediumint(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `mod_message`
--
ALTER TABLE `mod_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mod_message_template`
--
ALTER TABLE `mod_message_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mod_page`
--
ALTER TABLE `mod_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mod_page_post`
--
ALTER TABLE `mod_page_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mod_page_snippet`
--
ALTER TABLE `mod_page_snippet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mod_search`
--
ALTER TABLE `mod_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mod_user`
--
ALTER TABLE `mod_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mod_user_contact`
--
ALTER TABLE `mod_user_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mod_user_country`
--
ALTER TABLE `mod_user_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `mod_user_email`
--
ALTER TABLE `mod_user_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mod_user_postal`
--
ALTER TABLE `mod_user_postal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
