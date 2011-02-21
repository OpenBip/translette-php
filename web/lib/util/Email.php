<?php

require_once ( dirname(__FILE__) . '/../images/Albums.php' );
require_once ( dirname(__FILE__) . '/../images/Images.php' );

class Email {
  public static function sendEmail($recipient, $subject, $message) {
    mail($recipient, $subject, $message);
  }
  
  public static function sendNewPasswordNotification($recipient, $newPassword) {
    mail($recipient, "LeMaSt Account Password Reset",
        "Your password for LeMaSt has been reset to: '$newPassword'."
        . "  Please log in and change it as soon as possible.");
  }
  
  public static function sendAccountConfirmation($recipient) {
    $headers = 'CC: jsteinbe@umich.edu' . "\r\n";
    $headers .= 'CC: dileonar@umich.edu' . "\r\n";
    $headers .= 'CC: emalin@umich.edu' . "\r\n";
    
    mail($recipient, "LeMaSt Account Confirmation",
        "This is to confirm that you have created an account with the LeMaSt "
        . "web application.",
        $headers);
  }
  
  public static function sendImage($recipient, $albumID, $sequencenum) {
    $image = Images::getImageHeader($albumID, $sequencenum);
    
    $imageURL = SiteConfiguration::getBaseURL()
        . "/image_get.php?albumID={$albumID}&sequencenum=$sequencenum";
    
    return mail($recipient, "Image: {$image->getFilename()}",
        "View your image at: $imageURL");
  }
  
}