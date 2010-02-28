CREATE TABLE `wp_base_url_mapping` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blog_id` bigint(20) NOT NULL,
  `base_url` varchar(255) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`,`base_url`,`active`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1
