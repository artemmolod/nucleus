CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `post` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `date_` int(11) NOT NULL,
  `accepted` int(11) NOT NULL,
  `del` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
