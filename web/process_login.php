<?php
require_once 'lib/util/SiteConfiguration.php';
require_once 'lib/util/SessionManager.php';
require_once 'lib/util/Forms.php';

require_once 'lib/users/Users.php';

SessionManager::startSession();

if (SessionManager::isUserLoggedIn()) {
  SessionManager::bowOutWithErrorMessage("You are already logged in -- "
      . "choose \"Log Out\" if you want to log in as another user.");
}

$frm_username = Forms::getParameter('username');
$frm_password = Forms::getParameter('password');

if (! Users::doesUserExist($frm_username)) {
  $showErrorMessage = "That user does not exist -- if you'd like to create "
      . "an account, click <a href='create_account.php'>here</a>.";
  include("login.php");
  die();
} else if (! Users::doesPasswordMatch($frm_username, $frm_password)) {
  $showErrorMessage = "Invalid password.";
   //  Have you forgotten it? "
     // . "Click <a href='process_password_reset.php?username=$frm_username'>here</a> to reset it.";
  include("login.php");
  die();
}

SessionManager::logUserIn($frm_username);
header("Location: index.php");
die();