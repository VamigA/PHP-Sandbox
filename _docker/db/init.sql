SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Create `chat` database.
--
CREATE DATABASE `chat`;

USE `chat`;

--
-- Table structure for table `users`.
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned auto_increment NOT NULL,
  `login` varchar(255) UNIQUE NOT NULL,
  `email` varchar(255),
  `password_hash` varchar(511) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`.
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) unsigned auto_increment NOT NULL,
  `sender_id` int(11) unsigned NOT NULL,
  `receiver_id` int(11) unsigned NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`receiver_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
