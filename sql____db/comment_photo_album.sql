CREATE TABLE IF NOT EXISTS `comment_photo_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `date_` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `del` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
