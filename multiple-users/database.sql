--
-- Database: `twitter`
--
-- --------------------------------------------------------
--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `screen_name` tinytext NOT NULL,
  `image_url` tinytext NOT NULL,
  `oauth_token_access` tinytext NOT NULL,
  `oauth_token_secret` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;