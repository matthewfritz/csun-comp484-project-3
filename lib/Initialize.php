<?php

/*
 * Initialize.php
 * Handles the initialization of all the library files.
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// array of library files to load
$files = [
	"Session",
	"Environment",
	"Database",
	"Redirect",
	"Authentication",
];

// iterate over and load all of the files
foreach($files as $file) {
	// a require_once will fail with a fatal error if a file cannot be loaded
	// and that's exactly the behavior we want
	require_once("framework/{$file}.php");
}

// load the environment configuration or die if the file was not able to be
// loaded successfully
if(!Environment::loadEnvironmentFile("../.env.php")) {
	die("Could not load environment file");
}

// set the default timezone according to the environment
date_default_timezone_set(env('APP_TIMEZONE'));