SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
CREATE DATABASE IF NOT EXISTS `will` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `will`;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` text NOT NULL,
  `blurb` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `posts` (`id`, `created`, `modified`, `title`, `blurb`, `content`, `image`) VALUES
(1, '2017-05-11 20:13:56', '2017-05-11 20:13:56', 'first blog post', 'lorem ipsum dolor sic amet', 'the quick brown fox jumped over the lazy dog', 'img/grid-page.jpg'),
(2, '2017-05-11 20:14:33', '2017-05-11 20:14:33', 'second post', 'she sells sea shells by the sea shore', 'peter piper picked a patch of pickled peppers', 'img/full-width-page.jpg'),
(4, '2017-05-11 20:14:43', '2017-05-11 20:14:43', '3rd', 'this page is intentionally left blank. ', 'this page is intentionally left blank. ', 'img/alternate-sidebar-page.jpg');


ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;