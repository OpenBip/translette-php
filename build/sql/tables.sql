USE translette;

DROP TABLE IF EXISTS chatmessage;
DROP TABLE IF EXISTS chatparticipant;
DROP TABLE IF EXISTS chat;
DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS language;

CREATE TABLE language(
  code        varchar(5)       PRIMARY KEY,
  name        varchar(20)      NOT NULL
) ENGINE=INNODB;
INSERT INTO language(name, code) VALUES ('AFRIKAANS', 'af');
INSERT INTO language(name, code) VALUES ('ALBANIAN', 'sq');
INSERT INTO language(name, code) VALUES ('AMHARIC', 'am');
INSERT INTO language(name, code) VALUES ('ARABIC', 'ar');
INSERT INTO language(name, code) VALUES ('ARMENIAN', 'hy');
INSERT INTO language(name, code) VALUES ('AZERBAIJANI', 'az');
INSERT INTO language(name, code) VALUES ('BASQUE', 'eu');
INSERT INTO language(name, code) VALUES ('BELARUSIAN', 'be');
INSERT INTO language(name, code) VALUES ('BENGALI', 'bn');
INSERT INTO language(name, code) VALUES ('BIHARI', 'bh');
INSERT INTO language(name, code) VALUES ('BULGARIAN', 'bg');
INSERT INTO language(name, code) VALUES ('BURMESE', 'my');
INSERT INTO language(name, code) VALUES ('CATALAN', 'ca');
INSERT INTO language(name, code) VALUES ('CHEROKEE', 'chr');
INSERT INTO language(name, code) VALUES ('CHINESE', 'zh');
INSERT INTO language(name, code) VALUES ('CHINESE_SIMPLIFIED', 'zh-CN');
INSERT INTO language(name, code) VALUES ('CHINESE_TRADITIONAL', 'zh-TW');
INSERT INTO language(name, code) VALUES ('CROATIAN', 'hr');
INSERT INTO language(name, code) VALUES ('CZECH', 'cs');
INSERT INTO language(name, code) VALUES ('DANISH', 'da');
INSERT INTO language(name, code) VALUES ('DHIVEHI', 'dv');
INSERT INTO language(name, code) VALUES ('DUTCH', 'nl');
INSERT INTO language(name, code) VALUES ('ENGLISH', 'en');
INSERT INTO language(name, code) VALUES ('ESPERANTO', 'eo');
INSERT INTO language(name, code) VALUES ('ESTONIAN', 'et');
INSERT INTO language(name, code) VALUES ('FILIPINO', 'tl');
INSERT INTO language(name, code) VALUES ('FINNISH', 'fi');
INSERT INTO language(name, code) VALUES ('FRENCH', 'fr');
INSERT INTO language(name, code) VALUES ('GALICIAN', 'gl');
INSERT INTO language(name, code) VALUES ('GEORGIAN', 'ka');
INSERT INTO language(name, code) VALUES ('GERMAN', 'de');
INSERT INTO language(name, code) VALUES ('GREEK', 'el');
INSERT INTO language(name, code) VALUES ('GUARANI', 'gn');
INSERT INTO language(name, code) VALUES ('GUJARATI', 'gu');
INSERT INTO language(name, code) VALUES ('HEBREW', 'iw');
INSERT INTO language(name, code) VALUES ('HINDI', 'hi');
INSERT INTO language(name, code) VALUES ('HUNGARIAN', 'hu');
INSERT INTO language(name, code) VALUES ('ICELANDIC', 'is');
INSERT INTO language(name, code) VALUES ('INDONESIAN', 'id');
INSERT INTO language(name, code) VALUES ('INUKTITUT', 'iu');
INSERT INTO language(name, code) VALUES ('IRISH', 'ga');
INSERT INTO language(name, code) VALUES ('ITALIAN', 'it');
INSERT INTO language(name, code) VALUES ('JAPANESE', 'ja');
INSERT INTO language(name, code) VALUES ('KANNADA', 'kn');
INSERT INTO language(name, code) VALUES ('KAZAKH', 'kk');
INSERT INTO language(name, code) VALUES ('KHMER', 'km');
INSERT INTO language(name, code) VALUES ('KOREAN', 'ko');
INSERT INTO language(name, code) VALUES ('KURDISH', 'ku');
INSERT INTO language(name, code) VALUES ('KYRGYZ', 'ky');
INSERT INTO language(name, code) VALUES ('LAOTHIAN', 'lo');
INSERT INTO language(name, code) VALUES ('LATVIAN', 'lv');
INSERT INTO language(name, code) VALUES ('LITHUANIAN', 'lt');
INSERT INTO language(name, code) VALUES ('MACEDONIAN', 'mk');
INSERT INTO language(name, code) VALUES ('MALAY', 'ms');
INSERT INTO language(name, code) VALUES ('MALAYALAM', 'ml');
INSERT INTO language(name, code) VALUES ('MALTESE', 'mt');
INSERT INTO language(name, code) VALUES ('MARATHI', 'mr');
INSERT INTO language(name, code) VALUES ('MONGOLIAN', 'mn');
INSERT INTO language(name, code) VALUES ('NEPALI', 'ne');
INSERT INTO language(name, code) VALUES ('NORWEGIAN', 'no');
INSERT INTO language(name, code) VALUES ('ORIYA', 'or');
INSERT INTO language(name, code) VALUES ('PASHTO', 'ps');
INSERT INTO language(name, code) VALUES ('PERSIAN', 'fa');
INSERT INTO language(name, code) VALUES ('POLISH', 'pl');
INSERT INTO language(name, code) VALUES ('PORTUGUESE', 'pt-PT');
INSERT INTO language(name, code) VALUES ('PUNJABI', 'pa');
INSERT INTO language(name, code) VALUES ('ROMANIAN', 'ro');
INSERT INTO language(name, code) VALUES ('RUSSIAN', 'ru');
INSERT INTO language(name, code) VALUES ('SANSKRIT', 'sa');
INSERT INTO language(name, code) VALUES ('SERBIAN', 'sr');
INSERT INTO language(name, code) VALUES ('SINDHI', 'sd');
INSERT INTO language(name, code) VALUES ('SINHALESE', 'si');
INSERT INTO language(name, code) VALUES ('SLOVAK', 'sk');
INSERT INTO language(name, code) VALUES ('SLOVENIAN', 'sl');
INSERT INTO language(name, code) VALUES ('SPANISH', 'es');
INSERT INTO language(name, code) VALUES ('SWAHILI', 'sw');
INSERT INTO language(name, code) VALUES ('SWEDISH', 'sv');
INSERT INTO language(name, code) VALUES ('TAJIK', 'tg');
INSERT INTO language(name, code) VALUES ('TAMIL', 'ta');
--INSERT INTO language(name, code) VALUES ('TAGALOG', 'tl');
INSERT INTO language(name, code) VALUES ('TELUGU', 'te');
INSERT INTO language(name, code) VALUES ('THAI', 'th');
INSERT INTO language(name, code) VALUES ('TIBETAN', 'bo');
INSERT INTO language(name, code) VALUES ('TURKISH', 'tr');
INSERT INTO language(name, code) VALUES ('UKRAINIAN', 'uk');
INSERT INTO language(name, code) VALUES ('URDU', 'ur');
INSERT INTO language(name, code) VALUES ('UZBEK', 'uz');
INSERT INTO language(name, code) VALUES ('UIGHUR', 'ug');
INSERT INTO language(name, code) VALUES ('VIETNAMESE', 'vi');
INSERT INTO language(name, code) VALUES ('WELSH', 'cy');
INSERT INTO language(name, code) VALUES ('YIDDISH', 'yi');
INSERT INTO language(name, code) VALUES ('UNKNOWN', '');

CREATE TABLE account(
  username    varchar(20)   PRIMARY KEY,
  firstname   varchar(60)   NOT NULL,
  lastname    varchar(60)   NOT NULL,
  password    varchar(40)   NOT NULL,
  language    varchar(5)    NOT NULL,
  avatar      mediumblob,
  
  FOREIGN KEY(language) REFERENCES language(code)
) ENGINE=INNODB;

CREATE TABLE chat(
  name        varchar(40)     primary key,
  passphrase  varchar(40)
) ENGINE=INNODB;

CREATE TABLE chatparticipant(
  chat        varchar(40)     NOT NULL,
  username    varchar(20)     NOT NULL,
  
  UNIQUE(chat, username),
  FOREIGN KEY(chat) REFERENCES chat(name),
  FOREIGN KEY(username) REFERENCES account(username)
) ENGINE=INNODB;

CREATE TABLE chatmessage(
  chat        varchar(40)     NOT NULL,
  message_time  timestamp     NOT NULL,
  username    varchar(20)     NOT NULL,
  language    varchar(40)     NOT NULL,
  message     varchar(200)    NOT NULL,
  
  FOREIGN KEY(chat, username) REFERENCES chatparticipant(chat, username)
) ENGINE=INNODB;