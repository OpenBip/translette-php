<?php

require_once "lib/util/SiteConfiguration.php";

require_once 'lib/util/SessionManager.php';
require_once 'lib/users/Users.php';
require_once 'lib/chat/Chats.php';
require_once 'lib/util/Forms.php';

if (! isset($chatName)) {
  $chatName = Forms::getParameter('chatName');
}

SessionManager::ensureParametersHaveBeenSupplied(array($chatName));

SessionManager::startSession();
if (! Chats::isParticipant($chatName, SessionManager::getLoggedInuser())) {
  SessionManager::bowOutWithErrorMessage("You are not a member of that chat.");
}

$pageTitle = "Welcome!";
include "template/header.php";

$defaultLanguage = Users::getDefaultLanguage(SessionManager::getLoggedInUser());
?>

<script type="text/javascript">
  dojo.require("dijit.layout.BorderContainer");
  dojo.require("dijit.layout.ContentPane");

  dojo.require("translette.ChatClient");
</script>

<div style="padding: 20px;">

  <div dojoType="translette.ChatClient"
      chatName="<?= $chatName ?>"
      defaultLanguage="<?= $defaultLanguage ?>"></div>

</div>

<?
// include "keyboard.html";
include "template/footer.php";
?>