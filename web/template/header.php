<?
require_once "lib/util/SessionManager.php";
SessionManager::startSession();
if (SessionManager::isUserLoggedIn()) {
  $pageTitle = "Welcome, " . SessionManager::getLoggedInUser();
} else {
  $pageTitle = "Welcome!";
}
?>

<head>
  <title><?= $pageTitle ?></title>
  <meta name="description" content="chat"/>
  <meta name="keywords" content="chat"/>
  <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"/>

  <style type="text/css">
    html, body { width: 100%; height: 100%; }
  </style>

  <link rel="stylesheet" type="text/css" href="css/reset-fonts-grids.css">
  <link rel="stylesheet" type="text/css" href="css/base.css">

  <!-- <link href="css/global-styles.css" rel="stylesheet" type="text/css" /> -->

  <script type="text/javascript">
    djConfig = {
        parseOnLoad: true,
        isDebug: true,
        baseUrl: "./",
        modulePaths: { translette: "javascript/translette" }
    };
  </script>
  <script src="http://ajax.googleapis.com/ajax/libs/dojo/1.4/dojo/dojo.xd.js"
      type="text/javascript"></script>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script type="text/javascript">google.load("language", "1");
      google.load("elements", "1", { packages: "transliteration" });</script>
  <link href="http://ajax.googleapis.com/ajax/libs/dojo/1.4/dojo/resources/dojo.css" rel="stylesheet" type="text/css" />
  <link href="http://ajax.googleapis.com/ajax/libs/dojo/1.4/dijit/themes/tundra/tundra.css" rel="stylesheet" type="text/css" />
</head>

<body class="tundra">

<div id="doc3" class="yui-t1">
  <div id="hd" style="padding: 15px; border-bottom: 1px solid black; height: 40px;">
    <img src="images/translate.png" style="height: 50px; float: left; margin-right: 10px;" />
    <span style="font-weight: bold; font-family: cursive; font-size: 22pt;">Translette</span>
  </div>
  <div id="bd" style="border-top: 3px solid orange; border-bottom: 3px solid orange;">
    <div class="yui-b">
      <ul>
        <li><a href="index.php">Home</a></li>
<? if (SessionManager::isUserLoggedIn()) : ?>
        <li><a href="list_chats.php">List Chats</a></li>
        <li><a href="create_chat.php">Create Chat</a></li>
        <li><a href="join_chat.php">Join Chat</a></li>
        <li><a href="update_account.php">Update Account Info</a></li>
        <li><a href="logout.php">Log Out</a></li>
<? else: ?>
        <li><a href="create_account.php">Create Account</a></li>
        <li><a href="login.php">Log In</a></li>
<? endif; ?>
      </ul>
    </div>

    <div id="yui-main">
      <div class="yui-b" style="border-left: thin dashed orange;">