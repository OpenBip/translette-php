<?php
require_once ( 'lib/util/SiteConfiguration.php' );
require_once ( 'lib/util/SessionManager.php' );
require_once ( 'lib/util/Forms.php' );

require_once ( 'lib/chat/Chats.php' );

$chatName = Forms::getParameter('chatName', Forms::METHOD_REQUEST);

$users = Chats::getParticipants($chatName);

$jsonResponse = array();
foreach ($users as $user) {
  $jsonResponse[] = array(
      "username"=>$user->getUsername(),
      "firstName"=>$user->getFirstName(),
      "lastName"=>$user->getLastName(),
      "language"=>$user->getLanguage());
}

echo json_encode($jsonResponse);
