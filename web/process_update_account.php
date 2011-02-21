<?php
require_once 'lib/util/SiteConfiguration.php';
require_once 'lib/util/SessionManager.php';
require_once 'lib/util/Forms.php';

require_once 'lib/users/Users.php';

SessionManager::startSession();
SessionManager::ensureUserIsLoggedIn();

if ($_FILES['avatar']['error'] != UPLOAD_ERR_OK &&
    $_FILES['avatar']['error'] != UPLOAD_ERR_NO_FILE) {
  SessionManager::bowOutWithErrorMessage("There was a problem with your avatar upload");
}

$password = Forms::getParameter('password');

$avatar = "";
if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
  $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
}

Users::updateUser(SessionManager::getLoggedInUser(), $password, $avatar);

header("Location: update_account.php");
die();
