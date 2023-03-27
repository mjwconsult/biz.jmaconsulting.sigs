<?php

require_once 'sigs.civix.php';
use CRM_Sigs_ExtensionUtil as E;

/**
 * Implementation of hook_civicrm_config
 */
function sigs_civicrm_config(&$config) {
  _sigs_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_install
 */
function sigs_civicrm_install() {
  _sigs_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_enable
 */
function sigs_civicrm_enable() {
  foreach (glob(E::path('/sql/*_enable.sql')) as $file) {
    CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, $file);
  }
  _sigs_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function sigs_civicrm_disable() {
  foreach (glob(E::path('/sql/*_disable.sql')) as $file) {
    CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, $file);
  }
}

/**
 * Implementation of hook_civicrm_tokens
 */
function sigs_civicrm_tokens(&$tokens) {
  $tokens['contact'] = ['contact.signature' => 'Your Signature Image'];
}

/**
 * Implementation of hook_civicrm_tokenValues
 */
function sigs_civicrm_tokenValues(&$values, &$contactIDs, $job = null, $tokens = []) {
  if ($_SESSION['CiviCRM']['userID']) {
    $imageId = CRM_Core_DAO::singleValueQuery('SELECT signature_image  FROM civicrm_value_email_signatures WHERE entity_id = %1',
      [1 => [$_SESSION['CiviCRM']['userID'], 'Integer']]);
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
