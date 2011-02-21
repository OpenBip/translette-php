<?php

require_once dirname(__FILE__) . '/Chat.php';
require_once dirname(__FILE__) . '/../users/User.php';

class Chats {
  public static function doesChatExist($chatName) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT count(*) AS numChats "
        . "FROM chat "
        . "WHERE name = '" . $cfg->mysql->ESCAPE($chatName) . "';");

    return mysql_fetch_object($result)->numChats > 0;
  }

  public static function isParticipant($chatName, $username) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT count(*) AS numParticipants "
        . "FROM chatparticipant "
        . "WHERE chat = '" . $cfg->mysql->ESCAPE($chatName) . "' "
          . "AND username = '" . $cfg->mysql->ESCAPE($username) . "';");

    return mysql_fetch_object($result)->numParticipants > 0;
  }

  public static function getChats($username) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT chat.* "
        . "FROM chat "
        . "INNER JOIN chatparticipant "
          . "ON chat.name = chatparticipant.chat "
        . "WHERE username = '" . $cfg->mysql->ESCAPE($username) . "';");

    $chats = array();
    while ($entry = mysql_fetch_object($result)) {
      $chats[] = new Chat($entry->name);
    }
    return $chats;
  }

  public static function addChat($chatname, $passphrase) {
    global $lemast_config; $cfg = $lemast_config;

    $cfg->mysql->executeQuery('INSERT INTO chat'
          . '(name, passphrase) '
          . sprintf("VALUES ('%s', '%s');",
             $cfg->mysql->ESCAPE($chatname),
             $cfg->mysql->ESCAPE($passphrase)));
  }

  public static function addUser($chatname, $passphrase, $username) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT passphrase FROM chat " .
        "WHERE name = '" . $cfg->mysql->ESCAPE($chatname) .
        "';");
    $chat_info = mysql_fetch_object($result);

    if ($chat_info->passphrase != $cfg->mysql->ESCAPE($passphrase)) return false;

    $cfg->mysql->executeQuery('INSERT INTO chatparticipant'
          . '(chat, username) '
          . sprintf("VALUES ('%s', '%s');",
             $cfg->mysql->ESCAPE($chatname),
             $cfg->mysql->ESCAPE($username)));

     return true;
  }

  public static function getParticipants($chatName) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT account.* FROM chatparticipant "
        . "INNER JOIN account ON chatparticipant.username = account.username "
       . "WHERE chatparticipant.chat = '" . $cfg->mysql->ESCAPE($chatName) .
        "' ORDER BY account.lastname;");

    $users = array();
    while ($entry = mysql_fetch_object($result)) {
      $users[] = new User($entry->username, $entry->firstname,
          $entry->lastname, $entry->language);
    }
    return $users;
  }
}