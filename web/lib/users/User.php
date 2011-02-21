<?php

/**
 *
 * Represents a user/account in the system.
 *
 * @author lemast
 *
 */

class User {

  // - -  Private Members

  private $username;
  private $firstName;
  private $lastName;
  private $language;


  // - -  Constructor

  /**
   *
   * @param $username
   * @param $firstName
   * @param $lastName
   * @param $admin
   */
  public function __construct($username, $firstName, $lastName, $language) {
    $this->username = $username;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->language = $language;
  }


  // - - -  Public Functions

  public function getFullName() {
    return $this->lastName . ', ' . $this->firstName;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getFirstName() {
    return $this->firstName;
  }

  public function getLastName() {
    return $this->lastName;
  }

  public function getLanguage() {
    return $this->language;
  }
}
