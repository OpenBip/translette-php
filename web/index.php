<?php

require_once "lib/util/SiteConfiguration.php";

$pageTitle = "Welcome!";

include "template/header.php"; ?>

<div style="padding: 20px;">
<h2><?
if (SessionManager::isUserLoggedIn()) : ?>
  Welcome, <?= SessionManager::getLoggedInUser() ?>!
<? else: ?>
  Welcome!
<? endif; ?></h2>

<? if (isset($lemastErrorMessage)) { ?>
  <font color="red"><?= $lemastErrorMessage ?></font>
<? } ?>

</div>

<?
include "template/footer.php";
?>