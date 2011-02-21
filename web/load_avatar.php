<?php
require_once ( 'lib/util/SiteConfiguration.php' );
require_once( 'lib/util/Forms.php' );
require_once( 'lib/util/SessionManager.php' );

require_once 'lib/users/Users.php';

SessionManager::startSession();
SessionManager::checkAndHandleSessionExpiration();

$username = Forms::getParameter('username');

SessionManager::ensureParametersHaveBeenSupplied(array($username));

$imageBytes = Users::getAvatar($username);

echo $imageBytes;
?>