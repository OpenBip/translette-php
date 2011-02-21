<?php
require_once 'lib/util/SiteConfiguration.php';
require_once 'lib/util/SessionManager.php';
require_once 'lib/util/Forms.php';

require_once 'lib/users/Users.php';

SessionManager::startSession();
if (SessionManager::isUserLoggedIn()) {
  SessionManager::bowOutWithErrorMessage("You cannot create an account while logged in");
}

if ($_FILES['avatar']['error'] != UPLOAD_ERR_OK &&
    $_FILES['avatar']['error'] != UPLOAD_ERR_NO_FILE) {
  SessionManager::bowOutWithErrorMessage("There was a problem with your avatar upload");
}

$username = Forms::getParameter('username');
$password = Forms::getParameter('password');

$firstname = Forms::getParameter('firstname');
$lastname = Forms::getParameter('lastname');

$language = Forms::getParameter('language');

$avatar = "";
if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
  $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
}

SessionManager::ensureParametersHaveBeenSupplied(array($username, $password, $firstname, $lastname, $language));

Users::addUser($username, $password, $firstname, $lastname, $language, $avatar);

SessionManager::logUserIn($username);
header("Location: index.php");
die();
