<?php

require_once "lib/util/SiteConfiguration.php";

require_once 'lib/util/SessionManager.php';
require_once 'lib/chat/Chats.php';
require_once 'lib/util/Forms.php';

SessionManager::startSession();
$pageTitle = "Current chats for " . SessionManager::getLoggedInUser();
include "template/header.php";

SessionManager::ensureUserIsLoggedIn();

$chats = Chats::getChats(SessionManager::getLoggedInUser());

?>

<script type="text/javascript">
  dojo.require("dijit.layout.BorderContainer");
  dojo.require("dijit.layout.ContentPane");

  dojo.require("lemast.ChatClient");
</script>

<div style="padding: 20px;">

  <h2>Current chats for <?= SessionManager::getLoggedInUser() ?></h2>

<?
  for ($i = 0; $i < count($chats); ++$i) {
    $chat = $chats[$i];
    $users = Chats::getParticipants($chat->getName());
?>
  <a href="chat.php?chatName=<?= urlencode($chat->getName()) ?>"
      method="GET"><?= $chat->getName() ?></a><br />

  Participants:<br />
  <? for ($j = 0; $j < count($users); ++$j) {
        $user = $users[$j]; ?>
    <img src="load_avatar.php?username=<?= $user->getUsername() ?>"
        style="margin-left: 10px; float: left; height: 20px; width: 20px;" />
    <div style="margin-left: 5px; float: left;">
      <?= $user->getFirstName() ?> <?= $user->getLastName() ?>
      (language: <?= $user->getLanguage() ?>)
    </div>
    <br style="clear: both;" />
  <? }
  }
?>

</div>

<?
// include "keyboard.html";
include "template/footer.php";
?>