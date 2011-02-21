<?php
require_once ( 'lib/util/SiteConfiguration.php' );
require_once ( 'lib/util/SessionManager.php' );
require_once ( 'lib/util/Forms.php' );

require_once ( 'lib/chat/Messages.php' );

$chat = Forms::getParameter('chatName', Forms::METHOD_REQUEST);
$since = Forms::getParameter('since', Forms::METHOD_REQUEST);

//SessionManager::ensureParametersHaveBeenSupplied(array($chat));

$messages = Messages::getMessages($chat, $since);

$jsonResponse = array();
foreach ($messages as $message) {
  $jsonResponse[] = array(
      "username"=>$message->getUsername(),
      "chat"=>$message->getChat(),
      "message"=>$message->getMessage(),
      "language"=>$message->getLanguage(),
      "time"=>$message->getTimestamp());
}

echo json_encode($jsonResponse);
