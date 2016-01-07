-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2015 at 09:53 AM
-- Server version: 5.6.17
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `annoucements`
--

CREATE TABLE IF NOT EXISTS `annoucements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annoucement_title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `annoucement_description` text COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `for_all` int(11) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `annoucement_roles`
--

CREATE TABLE IF NOT EXISTS `annoucement_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annoucement_id` int(11) NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `annoucement_id` (`annoucement_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assigned_tickets`
--

CREATE TABLE IF NOT EXISTS `assigned_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `belongs_to` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unique_id` int(11) NOT NULL,
  `file_title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `file_description` text COLLATE utf8_unicode_ci,
  `file` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_hours`
--

CREATE TABLE IF NOT EXISTS `business_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `day` (`day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `unique_id` int(11) NOT NULL,
  `belongs_to` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE IF NOT EXISTS `custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `field_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `field_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `field_type` enum('text','number','email','url','textarea','select','radio','checkbox') COLLATE utf8_unicode_ci NOT NULL,
  `field_values` text COLLATE utf8_unicode_ci,
  `field_required` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_values`
--

CREATE TABLE IF NOT EXISTS `custom_field_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` int(11) DEFAULT NULL,
  `field_id` int(11) NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE IF NOT EXISTS `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `holiday_description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(10) unsigned NOT NULL,
  `to_user_id` int(10) unsigned NOT NULL,
  `subject` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `read` int(11) NOT NULL,
  `delete_sender` int(11) NOT NULL DEFAULT '0',
  `delete_receiver` int(11) NOT NULL DEFAULT '0',
  `attachment` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `from_user_id` (`from_user_id`,`to_user_id`),
  KEY `to_user_id` (`to_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `belongs_to` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unique_id` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` int(11) NOT NULL DEFAULT '0',
  `sign_in_only` int(11) NOT NULL DEFAULT '0',
  `page_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `page_slug` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `page_description` text COLLATE utf8_unicode_ci,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_slug` (`page_slug`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alternate_contact_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alternate_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `timezone_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assigned_roles_user_id_foreign` (`user_id`),
  KEY `assigned_roles_role_id_foreign` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_times`
--

CREATE TABLE IF NOT EXISTS `service_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` enum('low','medium','high','critical') COLLATE utf8_unicode_ci NOT NULL,
  `response_time` int(11) NOT NULL,
  `response_unit` enum('minute','hour','days') COLLATE utf8_unicode_ci NOT NULL,
  `response_time_type` enum('business_hour','calendar_hour') COLLATE utf8_unicode_ci DEFAULT NULL,
  `resolution_time` int(11) NOT NULL,
  `resolution_unit` enum('minute','hour','days') COLLATE utf8_unicode_ci NOT NULL,
  `resolution_time_type` enum('business_hour','calendar_hour') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_no` bigint(20) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `ticket_subject` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ticket_description` text COLLATE utf8_unicode_ci NOT NULL,
  `ticket_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `ticket_priority` enum('low','medium','high','critical') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'low',
  `ticket_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `response_due_time` timestamp NULL DEFAULT NULL,
  `resolution_due_time` timestamp NULL DEFAULT NULL,
  `responded` int(11) NOT NULL DEFAULT '0',
  `resolved` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_no` (`ticket_no`),
  KEY `ticket_type` (`ticket_type_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_responses`
--

CREATE TABLE IF NOT EXISTS `ticket_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `response_description` text COLLATE utf8_unicode_ci NOT NULL,
  `set_response_time` timestamp NULL DEFAULT NULL,
  `set_resolution_time` timestamp NULL DEFAULT NULL,
  `attachments` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

CREATE TABLE IF NOT EXISTS `ticket_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_type_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ticket_type_description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE IF NOT EXISTS `todos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `visibility` enum('public','private') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'private',
  `todo_title` text COLLATE utf8_unicode_ci NOT NULL,
  `todo_description` text COLLATE utf8_unicode_ci,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmation_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0',
  `provider` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_now` timestamp NULL DEFAULT NULL,
  `last_login_ip_now` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annoucements`
--
ALTER TABLE `annoucements`
  ADD CONSTRAINT `annoucements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `annoucement_roles`
--
ALTER TABLE `annoucement_roles`
  ADD CONSTRAINT `annoucement_role_annoucement_id_foreign` FOREIGN KEY (`annoucement_id`) REFERENCES `annoucements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annoucement_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assigned_tickets`
--
ALTER TABLE `assigned_tickets`
  ADD CONSTRAINT `assigned_ticket_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assigned_ticket_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  ADD CONSTRAINT `custom_field_values_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `assigned_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ticket_type_id_foreign` FOREIGN KEY (`ticket_type_id`) REFERENCES `ticket_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_responses`
--
ALTER TABLE `ticket_responses`
  ADD CONSTRAINT `ticket_responses_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `todos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`category`, `name`, `display_name`) VALUES
('language', 'set_language', 'Set Language'),
('language', 'manage_language', 'Manage Language'),
('custom_field', 'manage_custom_field', 'Manage Custom Field'),
('email_template', 'manage_template', 'Manage Template'),
('user', 'create_user', 'Create User'),
('user', 'manage_user', 'Manage User'),
('user', 'edit_user', 'Edit User'),
('user', 'view_user', 'View User'),
('user', 'delete_user', 'Delete User'),
('holiday', 'manage_holiday', 'Manage Holiday'),
('holiday', 'create_holiday', 'Create Holiday'),
('holiday', 'edit_holiday', 'Edit Holiday'),
('holiday', 'delete_holiday', 'Delete Holiday'),
('annoucement', 'manage_annoucement', 'Manage Annoucement'),
('annoucement', 'create_annoucement', 'Create Annoucement'),
('annoucement', 'edit_annoucement', 'Edit Annoucement'),
('annoucement', 'delete_annoucement', 'Delete Annoucement'),
('page', 'manage_page', 'Manage Page'),
('page', 'create_page', 'Create Page'),
('page', 'edit_page', 'Edit Page'),
('page', 'delete_page', 'Delete Page'),
('ticket', 'manage_ticket', 'Manage Ticket'),
('ticket', 'create_ticket', 'Create Ticket'),
('ticket', 'edit_ticket', 'Edit Ticket'),
('ticket', 'delete_ticket', 'Delete Ticket'),
('message', 'manage_message', 'Manage Message'),
('user', 'reset_user_password', 'Reset User Password'),
('ticket', 'view_ticket', 'View Ticket'),
('page', 'manage_default_pages', 'Manage Default Pages');