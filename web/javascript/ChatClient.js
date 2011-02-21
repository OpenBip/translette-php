dojo.provide("lemast.ChatClient");

dojo.require("dijit._Widget");
dojo.require("dijit._Templated");

dojo.require("dojox.data.GoogleSearchStore");
dojo.require("dijit.Dialog");

dojo.require("lemast.language");

dojo.declare("lemast.ChatClient",
    [ dijit._Widget, dijit._Templated ],
    
{
  d_lastMessageTime: null,
  i_messageIntervalID: -1,
  i_userIntervalID: -1,
  
  defaultLanguage: "",
  chatName: "",
  
  /** DOMElement holding the chat title */
  chatTitle: null,
  /** DOMElement holding the user's language */
  chatLanguage: null,
  /** DOMElement holding the chat contents */
  chatContents: null,
  /** DOMElement holding the user's pending text */
  pendingText: null,
  /** DOMElement */
  buttonSend: null,
  
  searchDialog: null,
  
  googleStore: null,
  
  postMixInProperties: function() {
    this.googleStore = new dojox.data.GoogleWebSearchStore({ lang: this.defaultLanguage });
    
    this.retrieveMessagesFromServer();
    this.i_messageIntervalID = setInterval(
        dojo.hitch(this, this.retrieveMessagesFromServer), 3000);
    this.retrieveUsersFromServer();
    this.i_userIntervalID = setInterval(
        dojo.hitch(this, this.retrieveUsersFromServer), 1000 * 60 * 5);
  },
  
  postCreate: function() {
    google.language.getBranding(this.googleBranding);
    dojo.connect(this.buttonSend, "onclick", this, "sendMessage");
    if (this.defaultLanguage == 'en') {
      this.buttonTransliteration.style.display = "none";
    } else {
      dojo.connect(this.buttonTransliteration, "onclick", this, "enableTransliteration");
    }
  },
  
  search: function(query) {
    dojo.empty(this.results);
//    while(list.firstChild){
//      list.removeChild(list.firstChild);
//    }

    this.searchDialog.show();
    this.googleStore.fetch(
        {query:{text: query},
          count: 15,
          
          onComplete: dojo.hitch(this, function(items, request) {
            dojo.forEach(items, dojo.hitch(this, function(item){
              console.debug(item);
              var li = document.createElement("li");
              li.style.textAlign = "left";
              li.innerHTML = "<a href=\"" + item.url  + "\">" + item.title + "</a> - " + item.content;
              this.results.appendChild(li);   
            }));
        })
        });
  },
  
  enableTransliteration: function() {
    var options = {
        sourceLanguage: 'en', // or google.elements.transliteration.LanguageCode.ENGLISH,
        destinationLanguage: [this.defaultLanguage], // or [google.elements.transliteration.LanguageCode.HINDI],
        shortcutKey: 'ctrl+g',
        transliterationEnabled: true
      };
      // Create an instance on TransliterationControl with the required
      // options.
      var control =
          new google.elements.transliteration.TransliterationControl(options);

      // Enable transliteration in the textfields with the given ids.
//      var ids = [ "transl1", "transl2" ];
      control.makeTransliteratable([ this.pendingText ]);

      // Show the transliteration control which can be used to toggle between
      // English and Hindi.
      control.showControl( this.transControl );
      
    this.buttonTransliteration.disabled = true;
  },
  
  sendMessage: function() {
    dojo.xhrGet({
      url: "processAddMessage.php",
      content: {
        chatName: this.chatName,
        language: this.defaultLanguage,
        message: this.pendingText.value
      },
      
//      handleAs: "json",
      
      load: dojo.hitch(this, function(response, args) {
        this.pendingText.value = '';
      }),
      
      error: function (response, args) {
        console.debug("Error", response);
      }
    });
  },
  
  setLanguage: function(language) {
    this.chatLanguage.innerHTML = language;
  },
  
  detectLanguage: function() {
    lemast.language.detectLanguage( this.pendingText.value,
        this.setLanguage );
  },
  
  retrieveUsersFromServer: function() {
    dojo.xhrGet({
      
      url: "process_get_users.php",
      content: {
        chatName: this.chatName
      },
  
      handleAs: "json",
  
      load: dojo.hitch(this, function (response, args) {
        dojo.empty(this.users);
        for (var i = 0; i < response.length; ++i) {
          var user = response[i];

          this.appendUserToChat(user.username, user.firstName, user.lastName, user.language);
        }
      }),
  
      error: function (response, args) {
        console.debug("Error", response);
      }
    });
  },
  
  retrieveMessagesFromServer: function() {
    dojo.xhrGet({
  
      url: "processGetMessages.php",
      content: {
        chatName: this.chatName,
        since: this.d_lastMessageTime == null ? "" : this.d_lastMessageTime
      },
  
      handleAs: "json",
  
      load: dojo.hitch(this, function (response, args) {
        var i = 0;
        for (i = 0; i < response.length; ++i) {
          var message = response[i];
          if (this.d_lastMessageTime == null || message.time > this.d_lastMessageTime) {
            this.d_lastMessageTime = message.time;
          }
          this.appendMessageToChat(message.username, message.time,
              message.language, message.message);
        }
  
      }),
  
      error: function (response, args) {
        console.debug("Error", response);
      }
    });
  },
  
  appendUserToChat: function(username, firstName, lastName, language) {
    var userDiv = document.createElement("div");
    userDiv.style.clear = "both";

    var avatar = document.createElement("img");
    avatar.style.width = "20px";
    avatar.style.height = "20px";
    avatar.src = "load_avatar.php?username=" + username;
    avatar.style.cssFloat = "left";
    userDiv.appendChild(avatar);
    
    var userSpan = document.createElement("span");
    userSpan.innerHTML = "<b>" + username + "</b>";
    userDiv.appendChild(userSpan);
    
    this.users.appendChild(userDiv);
  },
  
  appendMessageToChat: function(username, time, language, message) {
    var messageNode = document.createElement("div");
    messageNode.style.clear = "both";
    
    var avatar = document.createElement("img");
    avatar.style.width = "20px";
    avatar.style.height = "20px";
    avatar.src = "load_avatar.php?username=" + username;
    avatar.style.cssFloat = "left";

    var usernameNode = document.createElement("font");
    usernameNode.appendChild(document.createTextNode(username + " "));
    usernameNode.style.fontWeight = "bold";
    var timeNode = document.createElement("font");
    timeNode.appendChild(document.createTextNode("(" + time + "): "));
    timeNode.style.fontStyle = "italics";
    
    messageNode.appendChild(avatar);
    messageNode.appendChild(usernameNode);
    messageNode.appendChild(timeNode);

    if (language != this.defaultLanguage) {
      google.language.translate(message,
          language, this.defaultLanguage,
          dojo.hitch(this, function(result) {
            var originalText = document.createElement("font");
            originalText.color = "gray";
            originalText.appendChild(document.createTextNode(message));

            var newText = document.createElement("span");
            if (message == result.translation) {
              newText.innerHTML = " <font color='blue'>*" + language
                  + " - <font color='red'>not translated</font>*</font> ";
              var button = document.createElement("button");
              button.appendChild(document.createTextNode("Search"));
              dojo.connect(button, "onclick", dojo.hitch({ chat: this, queryString: message },
                  function() {
                    this.chat.search(this.queryString);
              }));
              newText.appendChild(button);
            } else {
              newText.innerHTML = " <font color='blue'>*" + language + "*</font> ";
              newText.appendChild(document.createTextNode(result.translation));
            }
            messageNode.appendChild(originalText);
            messageNode.appendChild(newText);

            this.chatContents.appendChild(messageNode);
          }));
    } else {
      var textNode = document.createTextNode(message);
      messageNode.appendChild(textNode);

      this.chatContents.appendChild(messageNode);
    }
  },
  
  templatePath: dojo.moduleUrl("lemast", "templates/ChatClient.html"),
  widgetsInTemplate: true

});