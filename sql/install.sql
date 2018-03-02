-- /*******************************************************
-- *
-- * civicrm_giro_communication
-- *
-- *******************************************************/

CREATE TABLE IF NOT EXISTS `civicrm_giro_scope` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `giro_type_num` int NOT NULL,
  `entity_id` int NOT NULL,
  `num` int NOT NULL,
  `description` varchar(255),
  PRIMARY KEY ( `id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci COMMENT='Giro communication';


CREATE TABLE IF NOT EXISTS `civicrm_giro_type` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `num` int unsigned NOT NULL,
  `entity` varchar(64) NOT NULL,
  `description` varchar(255),
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY ( `id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci COMMENT='Giro Communication Type';

INSERT INTO `civicrm_giro_type` (`id`, `num`, `entity`, `description`, `is_deleted`) VALUES
(1, 1, 'campaign', 'Any campaign', 0),
(2, 2, 'campaign', 'Marketing Mailing', 0),
(3, 11, 'campaign', 'Opération 11.11.11', 0),
(4, 20, 'contact', 'Any contributor', 0),
(5, 30, 'event', 'Any event', 0),
(6, 31, 'event', 'Running Team', 0),
(7, 3, 'event', 'dummy', 1);
