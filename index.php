<?php
// M: Start Session
session_start();

// M: Include Config
require('config.php');

// M: Include all the classes. TO DO: Try to fix the class autoloading function;
require 'App\Classes\Bootstrap.php';
require 'App\Classes\Controller.php';
require 'App\Classes\Model.php';
require 'App\Classes\Messages.php';
require 'App\Controllers\Home.php';
require 'App\Controllers\Ticket.php';
require 'App\Models\Home.php';
require 'App\Models\Ticket.php';

$bootstrap = new Bootstrap($_GET);
$controller = $bootstrap->createController();
if($controller){
	$controller->executeAction();
}