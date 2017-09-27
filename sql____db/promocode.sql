CREATE TABLE IF NOT EXISTS `promocode` (
  `id`             int(11) NOT NULL AUTO_INCREMENT,
  `promocode`      varchar(255) NOT NULL,
  `premiumAccount` int(11) NOT NULL,
  `countPoints`    int(11) NOT NULL,
  `activateLimit`  int(11) NOT NULL,
  `blockPromocode` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
