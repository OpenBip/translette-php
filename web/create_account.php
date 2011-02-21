<?php

require_once "lib/util/SiteConfiguration.php";

$pageTitle = "Create Account";

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
    action="process_add_account.php" method="post"
    enctype="multipart/form-data">
    
  <script type="text/javascript">
    dojo.require("lemast.language");
    
    dojo.addOnLoad(function() {
      var select = dojo.byId("language");
      
      for (var i in lemast.languages) {
        var option = document.createElement("option");
        
        option.value = i;
        option.innerHTML = lemast.languages[i];
        if (i == "en") option.selected = true;
        
        select.appendChild(option);
      }
    });
  </script>
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

  <h2>Create Your Account</h2>

  <p>
  <label for="username">Username</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      required="true" name="username"
      invalidMessage="Username was invalid" /><br />
      
  <label for="password">Password</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      required="true" type="password"
      name="password"
      invalidMessage="Password was invalid" />
  </p>

  <p>
  <label for="username">First Name</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      required="true" name="firstname"
      invalidMessage="Username was invalid" /><br />
      
  <label for="password">Last Name</label>:
  <input dojoType="dijit.form.ValidationTextBox"
      required="true" name="lastname"
      invalidMessage="Password was invalid" />
  </p>
  
  <p>
  <label for="language">Language</label>:
  <select id="language" name="language">
  </select>
  </p>

  <p>
  <label for="language">Avatar</label>:
  <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
  <input type="file" name="avatar" />
  </p>

  <input dojoType="dijit.form.Button"
      style="margin-left: 110px;"
      type="submit" label="Create Account" />
</form>
</div>

<?php
include "template/footer.php";
?>