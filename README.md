nilsdinghatlimit
================

`nilsdinghatlimit` ist ein Dienst, der eigentlich nichts anderes macht, als über andere Accounts, die sich bei dir eingeloggt haben, zu twittern. Hierfür verwende ich die twitteroauth-Dings von @abraham. 
Er ist schnell geschrieben worden und daher ist es mir eigentlich recht egal, was du mit dem Sourcecode machst.

Auch: AGPLv3

Installation
------------

Es wird benötigt:

* Webserver (getestet: lighttpd) mit 
* PHP5 und
* MySQL 
* ein Twitteraccount
* eine Twitter-Anwendung, die du dir [hier](https://dev.twitter.com/apps/new) erstellen kannst (benötigt "Read & Write"-Berechtigungen)

Die Installation sollte recht einfach sein. Einfach auf dem Server damit, die `config.php` verändern, die `init.php` ausführen (und nachher bestenfalls auch gleich löschen) und das sollte es gewesen sein. 
**Wichtig**: bei deiner Twitter-Anwendung tragst du unter "Settings" bei Callback URL den Link zu deiner callback.php ein. Es wäre auch empfehlenswert, den Haken bei "Allow this application to be used to Sign in with Twitter" zu setzen. 

Tweeten kannst du dann über die `tweet.php`, diese brauchst du einfach nur in einem Webbrowser aufrufen. 
