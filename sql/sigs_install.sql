SELECT @cGroupId := id FROM civicrm_custom_group WHERE name = 'Email_Signatures';
SELECT @maxWeight := max(weight) + 1 FROM civicrm_custom_group;

INSERT IGNORE INTO `civicrm_custom_group` (`id`, `name`, `title`, `extends`, `extends_entity_column_id`, `extends_entity_column_value`, `style`, `collapse_display`, `help_pre`, `help_post`, `weight`, `is_active`, `table_name`, `is_multiple`, `min_multiple`, `max_multiple`, `collapse_adv_display`, `created_id`, `created_date`) VALUES
(@cGroupId, 'Email_Signatures', 'Email Signatures', 'Contact', NULL, NULL, 'Inline', 1, '', '', @maxWeight, 1, 'civicrm_value_email_signatures', 0, NULL, NULL, 0, NULL, Now());

SELECT @cGroupId := id FROM civicrm_custom_group WHERE name = 'Email_Signatures';

INSERT INTO `civicrm_custom_field` (`custom_group_id`, `name`, `label`, `data_type`, `html_type`, `default_value`, `is_required`, `is_searchable`, `is_search_range`, `weight`, `help_pre`, `help_post`, `mask`, `attributes`, `javascript`, `is_active`, `is_view`, `options_per_line`, `text_length`, `start_date_years`, `end_date_years`, `date_format`, `time_format`, `note_columns`, `note_rows`, `column_name`, `option_group_id`, `filter`) VALUES
(@cGroupId, 'signature_image', 'Signature Image', 'File', 'File', NULL, 0, 0, 0, 2, NULL, 'Please select an image of your signature in .png or .jpg format.', NULL, NULL, NULL, 1, 0, NULL, 255, NULL, NULL, NULL, NULL, 60, 4, 'signature_image', NULL, NULL);

CREATE TABLE IF NOT EXISTS `civicrm_value_email_signatures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Default MySQL primary key',
  `entity_id` int(10) unsigned NOT NULL COMMENT 'Table that this extends',
  `signature_image` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_entity_id` (`entity_id`),
  KEY `FK_civicrm_value_email_signatures_1` (`signature_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

ALTER TABLE `civicrm_value_email_signatures`
  ADD CONSTRAINT `FK_civicrm_value_email_signatures_1` FOREIGN KEY (`signature_image`) REFERENCES `civicrm_file` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_civicrm_value_email_signatures_2` FOREIGN KEY (`entity_id`) REFERENCES `civicrm_contact` (`id`) ON DELETE CASCADE;
