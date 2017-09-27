CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_ver` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `bdate` varchar(255) NOT NULL, 
  `password` varchar(255) NOT NULL,
  `photo_src` varchar(255) NOT NULL,
  `king` int(11) NOT NULL,
  `del` int (11) NOT NULL,
  `block` int (11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
