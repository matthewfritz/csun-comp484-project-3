<?php

/*
 * Initialize.php
 * Handles the initialization of all the library files.
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// array of library framework files to load
$files = [
	"Session",
	"Environment",
	"Developer",
	"Database",
	"Redirect",
	"Menu",
	"Authentication",
];

// array of application-specific files to load
$appFiles = [
	"TsarbucksDatabase",
];

// iterate over and load all of the framework files
foreach($files as $file) {
	// a require_once will fail with a fatal error if a file cannot be loaded
	// and that's exactly the behavior we want
	require_once("framework/{$file}.php");
}

// iterate over and load all of the application-specific files
foreach($appFiles as $appFile) {
	// a require_once will fail with a fatal error if a file cannot be loaded
	// and that's exactly the behavior we want
	require_once("app/{$appFile}.php");
}

// load the environment configuration or die if the file was not able to be
// loaded successfully
if(!Environment::loadEnvironmentFile("../.env.php")) {
	die("Could not load environment file");
}

// set the default timezone according to the environment
date_default_timezone_set(env('APP_TIMEZONE'));