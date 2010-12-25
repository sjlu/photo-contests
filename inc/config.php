<?php

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

// Facebook configuration values
$config['fb']['appId'] = '172248606147614';
$config['fb']['secret'] = 'b14bb47234ed8c45f410e1b5032b380d';
$config['fb']['url'] = 'http://apps.facebook.com/discoveryapp';

// server configuration
$config['server']['url'] = 'http://apps.burst-dev.com/discoveryapp';

// database config
$config['db']['host'] = 'localhost';
$config['db']['username'] = 'discoveryapp';
$config['db']['password'] = 'K2wRu2epRuXEWAKEd25Traf4';
$config['db']['table'] = 'discoveryapp';

$db = new BurstMySQL($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['table']);

?>
