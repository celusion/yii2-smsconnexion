# yii2-smsconnexion
Send SMS messages using SMSConneXion API with only one line of code. 

Sign up at www.smsconnexion.com and start sending short messaging service messages to mobile phones across the world


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist celusion/yii2-smsconnexion "*"
```

or add

```
"celusion/yii2-smsconnexion": "*"
```

to the require section of your `composer.json` file.

Then, in your `params.php` file add the following params:
```php
    'smsconnexionusername' => '<Username>',
    'smsconnexionpassword' => '<YourPassword>',
```

Replace `<Username>` and `<YourPassword>` with the passwords you got after you signed up, of course!



Usage
-----

Once the extension is installed, simply use it in your code by :

```php

use celusion\smsconnexion\SMSConneXion;

//This sends the SMS message hello world to the mobile phone number 1234567890
SMSConneXion::sendSMS('1234567890','hello world');

```