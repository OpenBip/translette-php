INSERT INTO account(username, firstname, lastname, password, language)
    VALUES ('emalin', 'Eugene', 'Malin', 'emalin', 'ru');
INSERT INTO account(username, firstname, lastname, password, language)
    VALUES ('dileonar', 'Dickson', 'Leonard', 'dileonar', 'id');
INSERT INTO account(username, firstname, lastname, password, language)
    VALUES ('dileonar2', 'Dickson', 'Leonard', 'dileonar2', 'es');
INSERT INTO account(username, firstname, lastname, password, language)
    VALUES ('jsteinbe', 'Jim', 'Steinberger', 'jsteinbe', 'en');
INSERT INTO account(username, firstname, lastname, password, language)
    VALUES ('hans', 'Jim', 'Steinberger', 'hans', 'de');
INSERT INTO account(username, firstname, lastname, password, language)
    VALUES ('louis', 'Jim', 'Steinberger', 'louis', 'fr');
    
INSERT INTO chat VALUES ('Demo Chat', 'Demo Chat');

INSERT INTO chatparticipant(chat, username)
  VALUES ('Demo Chat', 'emalin');
INSERT INTO chatparticipant(chat, username)
  VALUES ('Demo Chat', 'dileonar');
INSERT INTO chatparticipant(chat, username)
  VALUES ('Demo Chat', 'jsteinbe');
INSERT INTO chatparticipant(chat, username)
  VALUES ('Demo Chat', 'dileonar2');
INSERT INTO chatparticipant(chat, username)
  VALUES ('Demo Chat', 'hans');
INSERT INTO chatparticipant(chat, username)
  VALUES ('Demo Chat', 'louis');
