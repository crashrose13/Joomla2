CREATE TABLE  IF NOT EXISTS `#__loginboss_providers` (
`provider` VARCHAR( 10 ) NOT NULL ,
`title` VARCHAR( 255 ) NOT NULL ,
`enabled` TINYINT NOT NULL ,
`client_id` VARCHAR( 255 ) NOT NULL ,
`client_secret` VARCHAR( 255 ) NOT NULL ,
`image` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY (  `provider` )
);

CREATE TABLE IF NOT EXISTS `#__loginboss_oauth_users` (
  `user_id` int(11) NOT NULL,
  `provider` varchar(10) NOT NULL,
  `unique_name` varchar(50) NOT NULL,
  `linked` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`provider`,`unique_name`),
  UNIQUE KEY `user_id` (`user_id`,`provider`,`unique_name`)
) DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('twitter', 'Twitter', '0', 'components/com_loginboss/images/twitter-icon.png');
INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('google', 'Google', '0', 'components/com_loginboss/images/google-icon.png');
INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('facebook', 'Facebook', '0', 'components/com_loginboss/images/facebook-icon.png');
INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('yahoo', 'Yahoo', '0', 'components/com_loginboss/images/yahoo-icon.png');
INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('linkedin', 'LinkedIn', '0', 'components/com_loginboss/images/linkedin-icon.png');
INSERT IGNORE INTO `#__loginboss_providers` (provider, title, enabled, image) VALUES ('microsoft', 'Microsoft', '0', 'components/com_loginboss/images/microsoft-icon.png');
