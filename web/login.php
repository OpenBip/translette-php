<?php
require_once 'lib/util/SiteConfiguration.php';
require_once 'lib/util/SessionManager.php';
require_once 'lib/users/Users.php';
require_once 'lib/util/Forms.php';

SessionManager::startSession();

if (SessionManager::isUserLoggedIn()) {
  SessionManager::bowOutWithErrorMessage("You are already logged in -- "
      . "choose \"Log Out\" if you want to log in as another user.");
}

$pageTitle = "Log In";
include('template/header.php'); ?>

<script type="text/javascript">
dojo.require("dijit.form.Form");
dojo.require("dijit.form.ValidationTextBox");
dojo.require("dijit.form.Button");
</script>

<style>
<!--
label {
  width: 100px;
  text-align: right;
  font-weight: bold;
  display: block;
  float: left;
}
-->
</style>


<div style="padding: 20px;">

<? if (isset($showErrorMessage)) : ?>
<div class="page-error-outer"><div class="page-error"><?= $showErrorMessage ?></div></div>
<? endif; ?>


<div class="page-description">
Please enter your username and password to log in.
</div>

<form action="process_login.php" method="post" dojoType="dijit.form.Form">
  <script type="dojo/method" event="onReset">
    return confirm('Press OK to reset widget values');
  </script>
  <script type="dojo/method" event="onSubmit">
    if (! this.validate()) {
      alert('Form contains invalid data.  Please correct first');
      return false;
    }
    return true;
  </script>

  <h2>Log In</h2>

  <p>
  <label for="username">Username</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      required="true"
      name="username"
      invalidMessage="Username was invalid" />
  </p>

  <p>
  <label for="password">Password</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      name="password"
      required="true" type="password"
      invalidMessage="Password was invalid" />
  </p>

  <input dojoType="dijit.form.Button"
      style="margin-left: 110px;"
      type="submit" label="Log In" />
</form>
</div>

<? include('template/footer.php'); ?>
