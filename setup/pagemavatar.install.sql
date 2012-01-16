CREATE TABLE IF NOT EXISTS `cot_pagemavatar` (
    `mav_id` int(11) NOT NULL AUTO_INCREMENT,
    `mav_pid` int(11) NOT NULL,
    `mav_uid` int(11) NOT NULL,
    `mav_item` int(11) NOT NULL,
    `mav_path` varchar(255) NOT NULL,
	`mav_desc` varchar(255) NOT NULL,
    PRIMARY KEY (`mav_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
