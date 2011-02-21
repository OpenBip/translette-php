dojo.provide("lemast.chat");

lemast.chat.retrieveMessagesFromServer = function() {
  console.debug("Requesting new messages");
  dojo.xhrGet({

    url: "processGetMessages.php",
    content: {
      chatName: "Test Chat",
      since: b_firstRetrieval ? "" : new Date()
    },

    handleAs: "json",

    load: function (response, args) {
      b_firstRetrieval = false;

      var i = 0;
      for (i = 0; i < response.length; ++i) {
        var message = response[i];
        lemast.chat.appendMessageToChat(message.username, message.time,
            message.language, message.message);
      }

    },

    error: function (response, args) {
      console.debug("Error", response);
    }
  });
};

lemast.chat.appendMessageToChat = function(username, time, language, message) {
  var messageNode = document.createElement("div");

  var usernameNode = document.createElement("font");
  usernameNode.appendChild(document.createTextNode(username + " "));
  usernameNode.style.fontWeight = "bold";
  var timeNode = document.createElement("font");
  timeNode.appendChild(document.createTextNode("(" + time + "): "));
  timeNode.style.fontStyle = "italics";
  messageNode.appendChild(usernameNode);
  messageNode.appendChild(timeNode);

  if (language != "en") {
    google.language.translate(message,
        language, "en",
        function(result) {
          var originalText = document.createElement("font");
          originalText.color = "gray";
          originalText.appendChild(document.createTextNode(message));

          var newText = document.createTextNode(" (from " + language + ") "
              + result.translation);

          messageNode.appendChild(originalText);
          messageNode.appendChild(newText);

          dojo.byId("destination").appendChild(messageNode);
        });
  } else {
    var textNode = document.createTextNode(message);
    messageNode.appendChild(textNode);

    dojo.byId("destination").appendChild(messageNode);

  }
};