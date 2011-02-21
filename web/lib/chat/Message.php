<?php

class Message {

  // - -  Private Members

  private $username;
  private $chat;
  private $message;
  private $language;
  private $timestamp;


  // - -  Constructor
  public function __construct($username, $chat, $message, $language, $timestamp) {
    $this->username = $username;
    $this->chat = $chat;
    $this->message = $message;
    $this->language = $language;
    $this->timestamp = $timestamp;
  }


  // - - -  Public Functions
  public function toJSON() {
    return json_encode(this);
  }

  public function getUsername() {
    return $this->username;
  }

  public function getChat() {
    return $this->chat;
  }

  public function getLanguage() {
    return $this->language;
  }

  public function getMessage() {
    return $this->message;
  }

  public function getTimestamp() {
    return $this->timestamp;
  }
}