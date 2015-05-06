Disclamer
=========

I use:
bootstrap transition v2.3.2

It's an old version of the framework. An update may be a good idea. But I don't
want take the time to do it.

Security
========
I quickly wrote this tool to be functionnal. It's protected with an http
authentification. I'm the single user of this app.

Do not use it in production :p

Installation
============
Install app in your public http folder.

App need php & mysql functionnal. Yes I known PHP :(

Create user & db
----------------

Open a mysql connexion as root and launch (replace 'your-pass' with right one):

```sql
CREATE USER 'postfix'@'localhost' IDENTIFIED BY 'your-pass';
GRANT USAGE ON *.* TO 'postfix'@'localhost' IDENTIFIED BY 'your-pass' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

CREATE USER 'postfix'@'localhost' IDENTIFIED BY 'your-pass';
GRANT USAGE ON *.* TO 'postfix'@'localhost' IDENTIFIED BY 'your-pass' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
CREATE DATABASE IF NOT EXISTS postfix;
GRANT ALL PRIVILEGES ON postfix.* TO 'postfix'@'localhost';

FLUSH PRIVILEGES;
```

Update postfix config
---------------------

```bash
# ALIAS DATABASE
alias_maps = hash:/etc/aliases, mysql:/etc/postfix/mysql-aliases.cf
alias_database = hash:/etc/aliases
local_recipient_maps = hash:/etc/aliases, mysql:/etc/postfix/mysql-aliases.cf
```

Content of /etc/postfix/mysql-aliases.cf:
```
sudo cp mysql-aliases.cf /etc/postfix/mysql-aliases.cf
```

And edit it to replace with right password

Update app configuration
------------------------

```bash
cp config.inc.php-ex config.inc.php
```

And edit your config.inc.php and replace with right values.
