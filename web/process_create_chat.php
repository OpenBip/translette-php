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

$errorMessage = null;
if (Chats::doesChatExist($chatname)) {
  $errorMessage = "A chat with that name already exists";
} else {
  Chats::addChat($chatname, $passphrase);
  Chats::addUser($chatname, $passphrase, SessionManager::getLoggedInUser());
}

$pageTitle = "Result";
include 'template/header.php';
?>

<div style="padding: 20px;">
<? if (is_null($errorMessage)) { ?>
  You have successfully created chat: <?= $chatname ?><br />
  The key phrase is: <?= $passphrase ?><br /><br />
  Share the chat name and passphrase with registered users you wish to join you.
<? } else { ?>
  <font color="red"><?= $errorMessage ?></font>
<? } ?>
</div>

<?
include 'template/footer.php';