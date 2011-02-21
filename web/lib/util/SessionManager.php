<?php

/**
 * Handles storing-to and reading-from the session.
 *
 * @author lemast
 */
class SessionManager {
  const KEY_USERNAME = "username";
  const KEY_LAST_ACTIVE = "lastActive";

  const EXPIRATION_TIME = 30000;


  // - -  Public Static Functions :: Session Lifecycle

  public static function startSession() {
    if (! session_id()) {
      session_start();
    }
  }


  // - -  Public Static Functions :: Session Validation

  public static function isUserLoggedIn() {
    if (! isset($_SESSION[self::KEY_USERNAME])) {
      return false;
    }

    return true;
  }

  /**
   * This needs to be called /before/ any other output/headers have been sent.
   * @param string $message
   */
  public static function bowOutWithErrorMessage($message) {
    $lemastErrorMessage = $message;
    include("index.php");
    die();
  }

  public static function ensureUserIsLoggedIn() {
    if (! self::isUserLoggedIn() || self::checkAndHandleSessionExpiration()) {
      header("Location: login.php");
      die();
    }
  }

  public static function ensureParametersHaveBeenSupplied($params) {
    foreach ($params as $param) {
      if (! isset($param)) {
        self::bowOutWithErrorMessage("You have tried to access this page inappropriately.");
      }
    }
  }

  /**
   * Destroys the session if it's expired, and refreshes it if it hasn't.
   *
   * @return <code>true</code> if the session had expired, <code>false</code>
   *   otherwise.
   */
  public static function checkAndHandleSessionExpiration() {
    $lastActive = self::getSessionValue(self::KEY_LAST_ACTIVE);

    // If the timestamp is missing, treat this as session-expiration.
    if (! isset($lastActive)) {
      self::destroySession();
      return true;
    }

    if (time() > ($lastActive + self::EXPIRATION_TIME)) {
      self::destroySession();
      return true;
    }

    self::updateLastActiveTimestamp();
    return false;
  }


  // - -  Public Static Functions :: Session Interaction

  public static function getLoggedInUser() {
    return self::getSessionValue(self::KEY_USERNAME);
  }

  public static function logUserIn($username) {
    self::setSessionValue(self::KEY_USERNAME, $username);
    self::updateLastActiveTimestamp();
  }

  public static function updateLastActiveTimestamp() {
    self::setSessionValue(self::KEY_LAST_ACTIVE, time());
  }

  public static function destroySession() {
    session_unset();
    session_destroy();
  }

  // - -  Private Static Functions

  private static function encryptValue($value) {
    return preg_replace("'(.)'e",
      "dechex(ord('\\1'))",
      $value);
  }

  private static function decryptValue($value) {
    return preg_replace("'([\S,\d]{2})'e",
      "chr(hexdec('\\1'))",
      $value);
  }

  public static function setSessionValue($key, $value) {
    $_SESSION[$key] = self::encryptValue($value);
  }

  public static function getSessionValue($key) {
    if (! isset($_SESSION[$key])) {
      return NULL;
    }

    return self::decryptValue($_SESSION[$key]);
  }
}