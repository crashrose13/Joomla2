ALTER TABLE  `#__loginboss_oauth_users` DROP PRIMARY KEY ,
ADD PRIMARY KEY (  `provider`,`unique_name` );
ALTER TABLE  `#__loginboss_oauth_users` ADD UNIQUE KEY `user_id` (`user_id`,`provider`,`unique_name`);
ALTER TABLE  `#__loginboss_oauth_users` ADD  `linked` TINYINT NOT NULL DEFAULT  '0';