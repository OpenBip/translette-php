<?php

require_once( 'Message.php' );

class Messages {
  public static function getMessages($chat, $since) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT * "
        . "FROM chatmessage "
        . "WHERE chat = '" . $cfg->mysql->ESCAPE($chat) . "' "
            . (! is_null($since) ?
              ("AND message_time > '" . $cfg->mysql->ESCAPE($since) . "'")
              : "") . " ORDER BY message_time ASC;");

    $messages = array();
    while ($entry = mysql_fetch_object($result)) {
      $messages[] = new Message($entry->username,
          $entry->chat, $entry->message, $entry->language, $entry->{'message_time'});
    }
    return $messages;
  }

  public static function addMessage($chat, $message, $username, $language) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "INSERT INTO chatmessage(chat, message_time, username, language, message) "
        . "VALUES('" . $cfg->mysql->ESCAPE($chat) . "', now(), '"
            . $cfg->mysql->ESCAPE($username) . "', '"
            . $cfg->mysql->ESCAPE($language) . "', '" . $cfg->mysql->ESCAPE($message) . "')");
  }
}