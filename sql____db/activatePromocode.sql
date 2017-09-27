CREATE TABLE IF NOT EXISTS `activatePromocode` (
  `id`             int(11) NOT NULL AUTO_INCREMENT,
  `promocode`      varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
