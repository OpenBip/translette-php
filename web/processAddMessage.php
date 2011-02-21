<?php
require_once ( 'lib/util/SiteConfiguration.php' );
require_once ( 'lib/util/SessionManager.php' );
require_once ( 'lib/util/Forms.php' );

require_once ( 'lib/chat/Messages.php' );

SessionManager::startSession();
if (! SessionManager::isUserLoggedIn()) {
  die("You must be logged in");
}

$chat = Forms::getParameter('chatName', Forms::METHOD_REQUEST);
$message = Forms::getParameter('message', Forms::METHOD_REQUEST);
$language = Forms::getParameter('language', Forms::METHOD_REQUEST);

SessionManager::ensureParametersHaveBeenSupplied(array($chat, $message, $language));

$messages = Messages::addMessage($chat, $message,
    SessionManager::getLoggedInUser(), $language);