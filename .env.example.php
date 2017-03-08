<?php

// array that holds the environment configuration for this application
return [

	// application timezone
	'APP_TIMEZONE' => 'America/Los_Angeles',

	// application title
	'APP_TITLE' => 'Tsarbucks',

	// session configuration
	'SESSION_USER_ID' => 'user_id', // this is where the user ID will be stored in the session
	'SESSION_USER_OBJ' => 'user', // this is where the object representing the logged-in user will be stored in the session
	'SESSION_USER_ROLES' => 'user_roles', // this is where the array representing the user's roles will be stored

	// database configuration parameters
	'DATABASE_HOST' => '', // host
	'DATABASE_PORT' => '', // port
	'DATABASE_USER' => '', // username
	'DATABASE_PASS' => '', // password
	'DATABASE_NAME' => '', // name of the database

];