<?php
require_once 'lib/util/SiteConfiguration.php';
require_once 'lib/util/SessionManager.php';
require_once 'lib/util/Forms.php';

require_once 'lib/chat/Chats.php';

SessionManager::startSession();
SessionManager::ensureUserIsLoggedIn();

$chatname = Forms::getParameter('chatname');
$passphrase = Forms::getParameter('passphrase');

SessionManager::ensureParametersHaveBeenSupplied(array($chatname, $passphrase));

if (Chats::isParticipant($chatname, SessionManager::getLoggedInuser())) {
  SessionManager::bowOutWithErrorMessage("You are already a member of that chat.");
}

Chats::addUser($chatname, $passphrase, SessionManager::getLoggedInUser());

$chatName = $chatname;
include "chat.php";