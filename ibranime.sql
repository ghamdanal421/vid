-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18 يونيو 2020 الساعة 10:00
-- إصدار الخادم: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ibranime`
--

-- --------------------------------------------------------

--
-- بنية الجدول `allorders`
--

CREATE TABLE `allorders` (
  `order_ID` int(11) NOT NULL,
  `order_PurchasesUserID` int(11) NOT NULL,
  `order_UserID` int(11) NOT NULL,
  `order_Quantity` int(11) NOT NULL,
  `order_ItemID` int(11) NOT NULL,
  `order_Date` datetime NOT NULL,
  `order_status` int(11) NOT NULL,
  `order_Price` double NOT NULL,
  `addcomments` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `commOrders` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `contact`
--

CREATE TABLE `contact` (
  `ID` int(11) NOT NULL,
  `message` text NOT NULL COMMENT 'message In the User',
  `uesrName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `numberPon` varchar(255) NOT NULL,
  `userIDMass` int(11) NOT NULL,
  `massDate` datetime NOT NULL,
  `approveMass` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `credit`
--

CREATE TABLE `credit` (
  `credit_ID` int(11) NOT NULL,
  `credit_itemID` int(11) NOT NULL,
  `credit_orderID` int(11) NOT NULL,
  `credit_UserID` int(11) NOT NULL,
  `credit_outUserID` int(11) NOT NULL,
  `credit_Date` datetime NOT NULL,
  `credit_status` int(11) NOT NULL,
  `credit_note` varchar(255) NOT NULL,
  `credit_system` int(11) NOT NULL,
  `credit_number` double NOT NULL,
  `credit_type` tinyint(1) NOT NULL,
  `credit_operation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `favorite`
--

CREATE TABLE `favorite` (
  `favorite_ID` int(11) NOT NULL,
  `favorite_item` int(11) NOT NULL,
  `favorite_family` int(11) NOT NULL,
  `favorite_UserID` int(11) NOT NULL,
  `favorite_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `ingredients` varchar(255) NOT NULL COMMENT 'The ingredients contained in the dish',
  `Image` varchar(255) NOT NULL,
  `evaluation` varchar(255) NOT NULL COMMENT 'She evaluates the dish',
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `messages`
--

CREATE TABLE `messages` (
  `message_ID` int(11) NOT NULL COMMENT 'message ID ',
  `message_orderID` int(11) NOT NULL,
  `message_UserID` int(11) NOT NULL,
  `message_outUserID` int(11) NOT NULL,
  `message_Date` datetime NOT NULL,
  `messages_status` tinyint(1) NOT NULL,
  `message_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `notifications`
--

CREATE TABLE `notifications` (
  `notifications_ID` int(11) NOT NULL COMMENT 'notifications ID',
  `notifications_Info` text NOT NULL COMMENT 'notifications Info or text ',
  `notifications_Type` int(11) NOT NULL COMMENT 'notifications Type',
  `notifications_Date` datetime NOT NULL COMMENT 'notifications Date ',
  `notifications_Status` tinyint(1) NOT NULL COMMENT 'notifications Status\r\n0 or 1 is Status',
  `notifications_UserID` int(11) NOT NULL COMMENT 'notifications User ID is my notifications ',
  `notifications_SendID` int(11) NOT NULL COMMENT 'notifications Send ID\r\non user or admin '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- بنية الجدول `settings`
--

CREATE TABLE `settings` (
  `settings_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description_meta` text NOT NULL,
  `new_Date` datetime NOT NULL,
  `command` varchar(255) NOT NULL,
  `url_socia_media` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `settings`
--

INSERT INTO `settings` (`settings_ID`, `name`, `url`, `description_meta`, `new_Date`, `command`, `url_socia_media`) VALUES
(1, 'IBRANIME\r\n', 'http://IBRANIME\r\n.com/', 'أبراهيم انمي والفلام\r\n\r\n', '2020-04-30 07:41:12', '45', 'http://www.facebook.com/,http://www.twitter.com/,http://www.pinterest.com/');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To Identify User',
  `Username` varchar(255) NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'Identify User Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User Approval',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `approve` tinyint(1) NOT NULL COMMENT 'Confirm account information',
  `howsales` int(11) NOT NULL COMMENT 'How much sales',
  `Submit` tinyint(1) NOT NULL,
  `TelephoneNumber` varchar(255) NOT NULL COMMENT 'The User Telephone number',
  `IdentificationNumber` varchar(255) NOT NULL COMMENT 'The User Identification Number',
  `Banknumber` varchar(255) NOT NULL COMMENT 'The User Bank account number',
  `userGovernorate` varchar(255) NOT NULL,
  `userCity` varchar(255) NOT NULL,
  `Certificatefile` varchar(255) NOT NULL COMMENT 'The User Certificate file link',
  `OnlineUser` datetime NOT NULL COMMENT 'Online user',
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `numSendEmail` varchar(255) NOT NULL,
  `emailDate` datetime NOT NULL,
  `user_mony_pay` double NOT NULL,
  `user_mony_order` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allorders`
--
ALTER TABLE `allorders`
  ADD PRIMARY KEY (`order_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`),
  ADD KEY `commOrders` (`commOrders`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`credit_ID`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`favorite_ID`),
  ADD KEY `favorite_item` (`favorite_item`),
  ADD KEY `favorite_UserID` (`favorite_UserID`),
  ADD KEY `favorite_family` (`favorite_family`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_ID`),
  ADD KEY `message_outUserID` (`message_outUserID`),
  ADD KEY `message_UserID` (`message_UserID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notifications_ID`),
  ADD KEY `notifications_UserID` (`notifications_UserID`),
  ADD KEY `notifications_ibfk_2` (`notifications_SendID`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allorders`
--
ALTER TABLE `allorders`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `credit`
--
ALTER TABLE `credit`
  MODIFY `credit_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `favorite_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'message ID ', AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notifications_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'notifications ID', AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User', AUTO_INCREMENT=66;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`commOrders`) REFERENCES `allorders` (`order_ID`),
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`favorite_UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`message_outUserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_4` FOREIGN KEY (`message_UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- القيود للجدول `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`notifications_UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`notifications_SendID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
