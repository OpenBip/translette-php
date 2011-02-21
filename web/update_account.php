<?php

require_once "lib/util/SiteConfiguration.php";

$pageTitle = "Update Account";

include "template/header.php";

SessionManager::ensureUserIsLoggedIn();
?>

<script type="text/javascript">
dojo.require("dijit.form.Form");
dojo.require("dijit.form.ValidationTextBox");
dojo.require("dijit.form.Button");
</script>

<style>
<!--
label {
  width: 120px;
  text-align: right;
  font-weight: bold;
  display: block;
  float: left;
}
-->
</style>

<div style="padding: 20px;">
<form dojoType="dijit.form.Form" id="accountForm"
    action="process_update_account.php" method="post"
    enctype="multipart/form-data">
    
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

  <img width="150" src="load_avatar.php?username=<?= SessionManager::getLoggedInUser() ?>" style="float: right; margin-bottom: 20px;"/>

  <h2>Update Your Account</h2>

  <p>
  <label for="password">Update Password</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      type="password" name="password"
      invalidMessage="Password was invalid" /> (leave blank to keep your old password)
  </p>
  
  <p>
  <label for="language">Update Avatar</label>:
  <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
  <input type="file" name="avatar" /> (leave blank to keep current avatar)
  </p>

  <input dojoType="dijit.form.Button"
      style="margin-left: 110px;"
      type="submit" label="Update Account" />
</form>
</div>

<?php
include "template/footer.php";
?>