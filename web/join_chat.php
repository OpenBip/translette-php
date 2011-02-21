<?php

require_once "lib/util/SiteConfiguration.php";

$pageTitle = "Join Chat";

include "template/header.php";
?>

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
<form dojoType="dijit.form.Form" id="accountForm"
    action="process_join_chat.php" method="post">

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

  <h2>Join An Existing Chat</h2>

  <p>
  <label for="chatname">Chat Name</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      required="true" name="chatname"
      invalidMessage="Chat Name was invalid" /><br />

  <label for="passphrase">Passphrase</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      required="true" type="text"
      name="passphrase"
      invalidMessage="Passphrase was invalid" />
  </p>

  <input dojoType="dijit.form.Button"
      style="margin-left: 110px;"
      type="submit" label="Join Chat" />
</form>
</div>

<?php
include "template/footer.php";
?>