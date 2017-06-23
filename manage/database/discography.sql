CREATE TABLE `wp_discographies` (
  `discography_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `artist` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `img` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `old_id` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `release` date DEFAULT '',
  `release_multi` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `tracks` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`discography_id`),
  KEY `release` (`release`),
  KEY `artist` (`artist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;