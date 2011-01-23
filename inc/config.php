<?php

// README + NOTES
// canvas width: 760px
// tab width: 520px

/*
This is the configuration file used for the application.
It is for global variable propgation to files, the idea
of "change once, update all" kind of ordeal.

Anyways, these configuraiton variables should be
updated accordingly when something has changed or
needs changing.

This file will also call upon the Facebook API
and the MySQL.
*/

include 'facebook.php';
include 'database.php';

$config = array();

// Application configuration values.
$config['app']['checkAge'] = 1;
$config['app']['borderColor'] = '#4e001a';
$config['app']['bar-right'] = '10px';
$config['app']['bar-top'] = '-44px';

// Facebook configuration values
$config['fb']['appId'] = '136285896435221';
$config['fb']['apiKey'] = 'b48e75f2567d09bdd72925d46fb9dd62';
$config['fb']['secret'] = '33e2abaf759f42e33f75f3b2f00b10a6';
$config['fb']['url'] = 'http://apps.facebook.com/burst-promo';

// server configuration
$config['server']['url'] = 'http://apps.burst-dev.com/burst-promo';

// database config
$config['db']['host'] = 'localhost';
$config['db']['username'] = 'discoveryapp';
$config['db']['password'] = 'K2wRu2epRuXEWAKEd25Traf4';
$config['db']['database'] = 'discoveryapp';
$config['db']['table'] = 'discovery_valentine';

// a list of admins
$config['admins'] = array();

// the rest of this stuff shouldn't be touched
$db = new BurstMySQL($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['database'], $config['db']['table']);

$db->createTable($config['db']['table']);

$facebook = new Facebook(array(
   'appId' => $config['fb']['appId'],
   'api_key' => $config['fb']['apiKey'],
   'secret' => $config['fb']['secret'],
   'cookie' => true,
));

$session = $facebook->getSession();

if ($session)
   $user = $facebook->getUser();
else
   echo '<fb:redirect url="' . $facebook->getLoginUrl(array('canvas' => 1, 'fbconnect' => 0, 'api_key' => $config['fb']['apiKey'])) . '" />';

if (in_array($user, $config['admins']))
   $config['admin'] = true;

$GLOBALS['app_config'] = $config;

?>
