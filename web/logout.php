<?php
require_once( 'lib/util/SessionManager.php' );

session_start();

SessionManager::destroySession();
header("Location: index.php"); // Sending the browser a redirect
?>