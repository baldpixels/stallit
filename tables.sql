
TABLE: stalls
  stalls	CREATE TABLE `stalls` (
   `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
   `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `created_by` mediumint(8) unsigned NOT NULL,
   `name` varchar(24) NOT NULL,
   `description` varchar(80) NOT NULL,
   `access` varchar(12) NOT NULL DEFAULT 'public',
   `activity_points` int(11) NOT NULL DEFAULT '1',
   PRIMARY KEY (`id`),
   KEY `created_by` (`created_by`),
   CONSTRAINT `stalls_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1

TABLE: stories
  stories	CREATE TABLE `stories` (
   `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
   `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `title` varchar(48) NOT NULL,
   `content` longtext NOT NULL,
   `posted_by` mediumint(8) unsigned NOT NULL,
   `link` varchar(250) DEFAULT NULL,
   `stall_id` mediumint(8) unsigned NOT NULL,
   `points` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`),
   KEY `posted_by` (`posted_by`),
   KEY `stall_id` (`stall_id`),
   CONSTRAINT `fk_stall_id` FOREIGN KEY (`stall_id`) REFERENCES `stalls` (`id`) ON DELETE CASCADE,
   CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8

TABLE: users
  users	CREATE TABLE `users` (
   `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
   `username` varchar(18) NOT NULL,
   `password` varchar(250) NOT NULL,
   `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `red` tinyint(3) unsigned NOT NULL DEFAULT '255',
   `green` tinyint(3) unsigned NOT NULL DEFAULT '255',
   `blue` tinyint(3) unsigned NOT NULL DEFAULT '255',
   `alpha` decimal(3,2) unsigned NOT NULL DEFAULT '1.00',
   `points` int(11) NOT NULL DEFAULT '1',
   PRIMARY KEY (`id`),
   UNIQUE KEY `idx_unique_username` (`username`)
  ) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8

TABLE: comments
  comments	CREATE TABLE `comments` (
   `id` mediumint(9) NOT NULL AUTO_INCREMENT,
   `date_written` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `content` text NOT NULL,
   `written_by` mediumint(8) unsigned NOT NULL,
   `story` mediumint(8) unsigned NOT NULL,
   `points` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`),
   KEY `written_by` (`written_by`),
   KEY `comments_ibfk_2` (`story`),
   CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`story`) REFERENCES `stories` (`id`) ON DELETE CASCADE,
   CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`written_by`) REFERENCES `users` (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8
