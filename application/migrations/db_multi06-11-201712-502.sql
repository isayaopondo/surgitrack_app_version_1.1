# Dump tables in correct order to not violate constraints
DROP TABLE IF EXISTS `acl`;
DROP TABLE IF EXISTS `acl_actions`;
DROP TABLE IF EXISTS `acl_categories`;
DROP TABLE IF EXISTS `users`;




# Dump of table acl_categories
# ------------------------------------------------------------

CREATE TABLE `acl_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `category_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_code` (`category_code`),
  UNIQUE KEY `category_desc` (`category_desc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table acl_actions
# ------------------------------------------------------------

CREATE TABLE `acl_actions` (
  `action_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `action_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`action_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `acl_actions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `acl_categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(12) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `auth_level` tinyint(3) unsigned NOT NULL,
  `banned` enum('0','1') NOT NULL DEFAULT '0',
  `passwd` varchar(60) NOT NULL,
  `passwd_recovery_code` varchar(60) DEFAULT NULL,
  `passwd_recovery_date` datetime DEFAULT NULL,
  `passwd_modified_at` datetime DEFAULT NULL,
  `accountsadmin_id` int(11) DEFAULT NULL,
  `token` varchar(191) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dump of table acl
# ------------------------------------------------------------

CREATE TABLE `acl` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ai`),
  KEY `action_id` (`action_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `acl_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `acl_actions` (`action_id`) ON DELETE CASCADE,
  CONSTRAINT `acl_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table auth_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_sessions`;

CREATE TABLE `auth_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table ci_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table denied_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `denied_access`;

CREATE TABLE `denied_access` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  `reason_code` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table ips_on_hold
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ips_on_hold`;

CREATE TABLE `ips_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table login_errors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login_errors`;

CREATE TABLE `login_errors` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table strack_admin_calendar
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_admin_calendar`;

CREATE TABLE `strack_admin_calendar` (
  `block_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blocked_date` datetime DEFAULT NULL,
  `blocked_enddate` datetime DEFAULT NULL,
  `blocked_type` enum('0','1') DEFAULT '0' COMMENT '0= Blocked Days, 1=Special Days',
  `blocked_reason` varchar(100) DEFAULT NULL,
  `blocked_reason_details` tinytext,
  `facility_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_booking
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_booking`;

CREATE TABLE `strack_booking` (
  `booking_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `procedure_id` int(11) DEFAULT NULL,
  `laterality` varchar(20) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booked_by` int(11) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `admission_notes` text,
  `admitted_by` int(11) DEFAULT NULL,
  `booking_status` enum('0','1','2','3','9','99','-1') DEFAULT '0',
  `surgerydate` datetime NOT NULL,
  `surgery_notes` text,
  `anesthesia` varchar(100) DEFAULT NULL,
  `postopbed` varchar(100) DEFAULT NULL,
  `theatre_id` int(11) DEFAULT NULL,
  `op_procedure` int(11) DEFAULT NULL,
  `op_notes` text,
  `operation_done` varchar(150) DEFAULT NULL,
  `op_date_start` datetime DEFAULT NULL,
  `op_date_end` datetime DEFAULT NULL,
  `op_recorded_by` int(11) DEFAULT NULL,
  `op_recorded_on` datetime DEFAULT NULL,
  `opnotes_file_name` varchar(200) DEFAULT NULL,
  `opnotes_dropbox_folder` varchar(200) DEFAULT NULL,
  `opnotes_file_created_on` datetime DEFAULT NULL,
  `opnotes_generated_by` int(11) DEFAULT NULL,
  `opcoding_file_name` varchar(200) DEFAULT NULL,
  `opcoding_dropbox_folder` varchar(200) DEFAULT NULL,
  `opcoding_file_created_on` datetime DEFAULT NULL,
  `opcoding_generated_by` int(11) DEFAULT NULL,
  `anethesia_start` datetime DEFAULT NULL,
  `anethesia_end` datetime DEFAULT NULL,
  `anethesia_type` int(11) DEFAULT NULL,
  `surgeon_name` varchar(100) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `surgeon_uid` int(11) DEFAULT NULL,
  `surgeon_first_assistant` int(11) DEFAULT NULL,
  `surgeon_second_assistant` int(11) DEFAULT NULL,
  `surgeon_third_assistant` int(11) DEFAULT NULL,
  `surgeon_supervisor` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `firm_id` int(11) DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `surgery_indication` text,
  `booking_info` text,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `last_modified_by` int(11) DEFAULT NULL,
  `last_modified_on` timestamp NULL DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `slot_id` int(11) NOT NULL,
  `ward_id` int(11) NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_department_firms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_department_firms`;

CREATE TABLE `strack_department_firms` (
  `firm_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `firm_name` varchar(150) DEFAULT NULL,
  `firm_info` text,
  `firm_phone` varchar(100) DEFAULT NULL,
  `firm_color` varchar(50) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `department_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_department_firms_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_department_firms_users`;

CREATE TABLE `strack_department_firms_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `firm_id` int(11) NOT NULL,
  `current_user` enum('0','1') NOT NULL DEFAULT '0',
  `date_assigned` date NOT NULL,
  `date_unassigned` date NOT NULL,
  `created_on` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `approved` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_department_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_department_users`;

CREATE TABLE `strack_department_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `department_id` int(11) NOT NULL,
  `current_user` enum('0','1') NOT NULL DEFAULT '0',
  `date_assigned` date NOT NULL,
  `date_unassigned` datetime NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `approved` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_departments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_departments`;

CREATE TABLE `strack_departments` (
  `department_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(150) DEFAULT NULL,
  `department_phone` varchar(100) DEFAULT NULL,
  `department_info` mediumtext,
  `isdeleted` enum('0','1') DEFAULT '0',
  `facility_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facilities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facilities`;

CREATE TABLE `strack_facilities` (
  `facility_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `facility_name` varchar(100) DEFAULT NULL,
  `facility_town` varchar(50) DEFAULT NULL,
  `facility_phone` varchar(50) DEFAULT NULL,
  `facility_address` text,
  `facility_location` varchar(191) DEFAULT NULL,
  `accountsfacility_id` int(11) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `ispublic` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`facility_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facilities_setup
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facilities_setup`;

CREATE TABLE `strack_facilities_setup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `facility_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_users` tinyint(4) DEFAULT '0',
  `is_departments` tinyint(4) DEFAULT '0',
  `is_procedures` tinyint(4) DEFAULT '0',
  `is_wards` tinyint(4) DEFAULT '0',
  `is_theatres` tinyint(4) DEFAULT '0',
  `is_firms` tinyint(4) DEFAULT '0',
  `is_complete` tinyint(4) DEFAULT '0',
  `modified_at` timestamp NULL DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facility_procedure_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facility_procedure_categories`;

CREATE TABLE `strack_facility_procedure_categories` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(150) DEFAULT NULL,
  `category_description` text,
  `facility_id` int(11) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facility_procedure_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facility_procedure_groups`;

CREATE TABLE `strack_facility_procedure_groups` (
  `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(150) DEFAULT NULL,
  `group_description` text,
  `facility_id` int(11) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facility_procedure_subgroups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facility_procedure_subgroups`;

CREATE TABLE `strack_facility_procedure_subgroups` (
  `subgroup_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subgroup_name` varchar(150) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `subgroup_description` text,
  `facility_id` int(11) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`subgroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facility_procedures
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facility_procedures`;

CREATE TABLE `strack_facility_procedures` (
  `procedure_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `procedure_name` varchar(150) DEFAULT NULL,
  `procedure_description` text,
  `procedure_fullname` varchar(250) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `rpl_code` varchar(20) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `service_fee` decimal(18,2) DEFAULT NULL,
  `subgroup_id` int(11) DEFAULT NULL,
  `facility_id` int(11) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`procedure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facility_theatres
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facility_theatres`;

CREATE TABLE `strack_facility_theatres` (
  `theatre_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `theatre_name` varchar(150) DEFAULT NULL,
  `theatre_info` text,
  `theatre_phone` varchar(100) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `facility_id` int(11) DEFAULT NULL,
  `created_on` int(11) NOT NULL,
  `created_by` datetime NOT NULL,
  PRIMARY KEY (`theatre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facility_time_slots
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facility_time_slots`;

CREATE TABLE `strack_facility_time_slots` (
  `slot_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `slot_value` int(11) NOT NULL,
  `slot_name` varchar(150) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `facility_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facility_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facility_users`;

CREATE TABLE `strack_facility_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `facility_id` int(11) unsigned NOT NULL,
  `current_user` enum('0','1') NOT NULL DEFAULT '0',
  `auth_level` tinyint(4) DEFAULT NULL,
  `date_assigned` date NOT NULL,
  `date_unassigned` datetime NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `strack_facility_users` (`user_id`),
  CONSTRAINT `strack_facility_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_facility_wards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_facility_wards`;

CREATE TABLE `strack_facility_wards` (
  `ward_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `ward_name` varchar(150) DEFAULT NULL,
  `ward_info` text,
  `ward_phone` varchar(100) DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  `facility_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ward_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_insurance_companies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_insurance_companies`;

CREATE TABLE `strack_insurance_companies` (
  `insuranceco_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `insuranceco_name` varchar(100) DEFAULT NULL,
  `insuranceco_phone` varchar(100) DEFAULT NULL,
  `insuranceco_email` varchar(100) DEFAULT NULL,
  `facility_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`insuranceco_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_mapt
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_mapt`;

CREATE TABLE `strack_mapt` (
  `mapt_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `procedure_id` int(11) DEFAULT NULL,
  `mapt_name` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `keywords` varchar(250) DEFAULT NULL,
  `notes` text,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`mapt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_mapt_criteria
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_mapt_criteria`;

CREATE TABLE `strack_mapt_criteria` (
  `criteria_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mapt_id` int(11) DEFAULT NULL,
  `criteria_name` varchar(200) DEFAULT NULL,
  `criteria_weight` varchar(200) DEFAULT NULL,
  `additional_info` tinytext,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`criteria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_mapt_criteria_scores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_mapt_criteria_scores`;

CREATE TABLE `strack_mapt_criteria_scores` (
  `score_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `score_value` varchar(20) DEFAULT NULL,
  `score_text` varchar(100) DEFAULT NULL,
  `criteria_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`score_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_mapt_patients_score
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_mapt_patients_score`;

CREATE TABLE `strack_mapt_patients_score` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `criteria_id` int(11) DEFAULT NULL,
  `score_id` int(11) DEFAULT NULL,
  `score_value` varchar(11) DEFAULT NULL,
  `mapt_score_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_mapt_patients_score_instance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_mapt_patients_score_instance`;

CREATE TABLE `strack_mapt_patients_score_instance` (
  `mapt_score_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) DEFAULT NULL,
  `mapt_id` int(11) DEFAULT NULL,
  `procedure_id` int(11) DEFAULT NULL,
  `scoredate` datetime DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`mapt_score_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_patient_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_patient_log`;

CREATE TABLE `strack_patient_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `log_type` varchar(20) DEFAULT NULL,
  `log_action` varchar(100) NOT NULL,
  `log_info` text NOT NULL,
  `access_ip` varchar(100) NOT NULL,
  `access_agent` varchar(200) NOT NULL,
  `log_url` varchar(100) NOT NULL,
  `log_access_method` varchar(100) NOT NULL,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_patients_list
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_patients_list`;

CREATE TABLE `strack_patients_list` (
  `patient_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `facility_id` int(11) DEFAULT NULL,
  `folder_number` varchar(50) NOT NULL DEFAULT '',
  `surname` varchar(100) NOT NULL DEFAULT '',
  `other_names` varchar(200) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  `phone3` varchar(50) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `suburb_id` varchar(100) DEFAULT NULL,
  `distance_km` varchar(50) DEFAULT NULL,
  `time_to_hospital` varchar(50) DEFAULT NULL,
  `firm_id` int(11) DEFAULT NULL,
  `cash` enum('0','1') DEFAULT '0',
  `insuranceco_id` int(11) DEFAULT NULL,
  `insurance_number` varchar(100) DEFAULT NULL,
  `language_id` int(11) NOT NULL DEFAULT '1',
  `additional_info` text,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `last_modified_by` int(11) DEFAULT NULL,
  `last_modified_on` timestamp NULL DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_priorities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_priorities`;

CREATE TABLE `strack_priorities` (
  `priority_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `priority_name` varchar(50) DEFAULT NULL,
  `calendar_color` varchar(50) DEFAULT NULL,
  `icon` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`priority_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_rpl_consumables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_rpl_consumables`;

CREATE TABLE `strack_rpl_consumables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `consumable_id` int(11) DEFAULT NULL,
  `procedure_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_rpl_procedure_codes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_rpl_procedure_codes`;

CREATE TABLE `strack_rpl_procedure_codes` (
  `rpl_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `procedure_id` int(11) DEFAULT NULL,
  `rpl_code` varchar(50) DEFAULT NULL,
  `service_fee` decimal(18,2) DEFAULT NULL,
  `rpl_decsription` tinytext,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `isdeleted` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`rpl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table strack_suburbs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `strack_suburbs`;

CREATE TABLE `strack_suburbs` (
  `suburb_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `suburb_name` varchar(100) DEFAULT NULL,
  `street_code` varchar(11) DEFAULT NULL,
  `postal_code` varchar(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `latitude` varchar(10) DEFAULT NULL,
  `longitude` varchar(10) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`suburb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_activity_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_activity_log`;

CREATE TABLE `user_activity_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `log_action` varchar(100) NOT NULL,
  `log_info` text NOT NULL,
  `access_ip` varchar(100) NOT NULL,
  `access_agent` varchar(200) NOT NULL,
  `log_url` varchar(100) NOT NULL,
  `log_access_method` varchar(100) NOT NULL,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table username_or_email_on_hold
# ------------------------------------------------------------

DROP TABLE IF EXISTS `username_or_email_on_hold`;

CREATE TABLE `username_or_email_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
