<?php
/**
 * Password recovery email view file; partial view.
 *
 * @copyright	Copyright &copy; 2013 Hardalau Claudiu 
 * @package		bum
 * @license		New BSD License 
 * 
 * When a user request for password recovery (password reset) this email is sent to the user's email.
 */

/* @var $modelPasswordRecovery model PasswordRecovery */
/* @var $moduleSiteEmailsContact module SiteEmailsContact */

echo eval($moduleSiteEmailsContact->body);
