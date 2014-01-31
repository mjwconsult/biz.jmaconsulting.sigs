ALTER TABLE `civicrm_value_email_signatures`
  DROP FOREIGN KEY `FK_civicrm_value_email_signatures_1`,
  DROP FOREIGN KEY `FK_civicrm_value_email_signatures_2`;

DROP TABLE IF EXISTS `civicrm_value_email_signatures`;

SELECT @cGroupId := id FROM civicrm_custom_group WHERE name = 'email_signatures';

DELETE FROM `civicrm_custom_field` WHERE `custom_group_id` = @cGroupId;

DELETE FROM `civicrm_custom_group` WHERE `id` = @cGroupId;