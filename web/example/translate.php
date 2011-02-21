<?php
?>

<html>

<head>
  <title></title>

    <script src="http://ajax.googleapis.com/ajax/libs/dojo/1.4/dojo/dojo.xd.js"
        type="text/javascript"></script>

  <script type="text/javascript" src="http://www.google.com/jsapi"></script>

  <script type="text/javascript">

    google.load("language", "1");

    function translate() {
      var text = dojo.byId("source").value;

      google.language.detect(text, function(result) {
        console.log(result);
        if (!result.error && result.language) {
          google.language.translate(text,
              result.language, "en",
              function(result) {
                console.log(result);
                var translated = document.getElementById("destination");
                if (result.translation) {
                  translated.innerHTML = result.translation;
                }
              });
        }
      });
    }
  </script>
</head>

<body>
  <input type="text" id="source" />
  <button onclick="translate()">Translate</button>
  <div style="border: thin solid black; width: 500px; height: 500px;"
      id="destination">

  </div>
</body>


</html>