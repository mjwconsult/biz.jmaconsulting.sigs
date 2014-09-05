<?php

require_once 'sigs.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function sigs_civicrm_config(&$config) {
  _sigs_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function sigs_civicrm_xmlMenu(&$files) {
  _sigs_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function sigs_civicrm_install() {
  return _sigs_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function sigs_civicrm_uninstall() {
  return _sigs_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function sigs_civicrm_enable() {
  foreach (glob(__DIR__ . '/sql/*_enable.sql') as $file) {
    CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, $file);
  }
  return _sigs_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function sigs_civicrm_disable() {
  foreach (glob(__DIR__ . '/sql/*_disable.sql') as $file) {
    CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, $file);
  }
  return _sigs_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function sigs_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _sigs_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function sigs_civicrm_managed(&$entities) {
  return _sigs_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_tokens
 */
function sigs_civicrm_tokens(&$tokens) {
  $tokens['contact'] = array('contact.signature' => 'Your Signature Image');
}

/**
 * Implementation of hook_civicrm_tokenValues
 */
function sigs_civicrm_tokenValues(&$values, &$contactIDs, $job = null, $tokens = array()) {
  if ($_SESSION['CiviCRM']['userID']) { 
    $imageId = CRM_Core_DAO::singleValueQuery('SELECT signature_image  FROM civicrm_value_email_signatures WHERE entity_id = %1', 
      array(1 => array($_SESSION['CiviCRM']['userID'], 'Integer')));
    foreach ($contactIDs as $contactID) {
      if ($imageId) {
        $url = CRM_Utils_System::url('civicrm/file', "reset=1&id={$imageId}&eid={$_SESSION['CiviCRM']['userID']}", TRUE, NULL, NULL, TRUE);
        $values[$contactID]['contact.signature'] = '<img src="' .$url. '"></img>';
      }
      else {
        $values[$contactID]['contact.signature'] = "";
      }
    }
  }
}