<?php
require_once( 'User.php' );

class Users {
  
  public static function getAvatar($username) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT avatar FROM account "
        . "WHERE username = '" . mysql_real_escape_string($username) . "';");
    $data = mysql_fetch_object($result);
        
    return $data->avatar;
  }

  public static function removeUser($username) {
    global $lemast_config; $cfg = $lemast_config;

    $cfg->mysql->executeQuery(
        "DELETE FROM account "
        . "WHERE username = '" . mysql_real_escape_string($username) . "';");
  }

  public static function doesUserExist($username) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT count(*) AS numUsers "
        . "FROM account "
        . "WHERE username = '" . mysql_real_escape_string($username) . "';");

    $entry = mysql_fetch_object($result);
    if ($entry->numUsers == 0) {
      return false;
    } else if ($entry->numUsers > 0) {
      return true;
    }

    die("A negative number of users?");
  }

  public static function doesPasswordMatch($username, $password) {
    if (! self::doesUserExist($username)) {
      return false;
    }

    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT password "
        . "FROM account "
        . "WHERE username = '" . $cfg->mysql->ESCAPE($username) . "';");

    $passwordInDB = mysql_fetch_object($result)->password;
    return $passwordInDB == $password;
  }

  /**
   * Returns all users sorted on their usernames.
   * @return User[]
   */
  public static function getUsersOrderedByUsername() {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
        "SELECT * "
        . "FROM account "
        . "ORDER BY username",
      "Could not query users: ");

    $users = array();
    while ($entry = mysql_fetch_object($result)) {
      $users[] = new User($entry->username);
    }

    return $users;
  }

  public static function addUser($username, $password, $firstname, $lastname, $language, $avatar) {
    global $lemast_config; $cfg = $lemast_config;
    
    $cfg->mysql->executeQuery('INSERT INTO account'
          . '(username, firstname, lastname, password, language, avatar) '
          . sprintf("VALUES ('%s', '%s', '%s', '%s', '%s', '%s');",
             $cfg->mysql->ESCAPE($username),
             $cfg->mysql->ESCAPE($firstname),
             $cfg->mysql->ESCAPE($lastname),
             $cfg->mysql->ESCAPE($password),
             $cfg->mysql->ESCAPE($language),
             $cfg->mysql->ESCAPE($avatar)));
  }

  public static function updateUser($username, $password, $avatar) {
    global $lemast_config; $cfg = $lemast_config;
    
    $set_query = "";
    if (strlen($password) > 0) {
      $set_query .= "password = '" . $cfg->mysql->ESCAPE($password) . "', ";
    }
    if (strlen($avatar) > 0) {
      $set_query .= "avatar = '" . $cfg->mysql->ESCAPE($avatar) . "', ";
    }
    
    if (strlen($set_query) == 0) return;
    
    $cfg->mysql->executeQuery(
      "UPDATE account "
      . "SET " . substr($set_query, 0, -2)
      . " WHERE username = '" . $cfg->mysql->ESCAPE($username) . "';");
  }

  public static function getUser($username) {
  	global $lemast_config; $cfg = $lemast_config;

  	$result = $cfg->mysql->executeQuery(
  		"SELECT * "
  		. "FROM account "
  		. "WHERE username = '" . $cfg->mysql->ESCAPE($username) . "';");

  	$entry = mysql_fetch_object($result);
  	$user = new User($entry->username);

  	return $user;
  }

  public static function resetPassword($username) {
    global $lemast_config; $cfg = $lemast_config;

    if (! Users::doesUserExist($username)) {
      return false;
    }

    $password = self::createRandomPassword();

    $cfg->mysql->executeQuery(
        "UPDATE account "
        . "SET password = '" . md5($cfg->mysql->ESCAPE($password)) . "' "
        . "WHERE username = '" . $cfg->mysql->ESCAPE($username) . "';");
  }

  /**
   * The letter l (lowercase L) and the number 1
   * have been removed, as they can be mistaken
   * for each other.
   */
  public static function createRandomPassword() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '';

    while ($i <= 10) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }

    return $pass;
  }

  public static function getDefaultLanguage($username) {
    global $lemast_config; $cfg = $lemast_config;

    $result = $cfg->mysql->executeQuery(
      "SELECT language "
      . "FROM account "
      . "WHERE username = '" . $cfg->mysql->ESCAPE($username) . "';");

    $entry = mysql_fetch_object($result);
    return $entry->language;
  }
}
