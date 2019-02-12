<?php

// MySQL Connection information variables.
$db 			= "";
$hostname 		= 'localhost';
$username 		= 'root';
$password 		= 'Mimi!#&@';
$database 		= 'streamer';

try
{ // Create connection to MySQL Database.
	$db = new PDO
		( // Check connection to db MySQL Database.
		"mysql:host=$hostname;dbname=$database",
		$username,
		$password
		);
	$db->setAttribute
		( // Prepare Attribute for Error Mode Exception Handling.
		PDO::ATTR_ERRMODE,
		PDO::ERRMODE_EXCEPTION
		);
}
catch(PDOException $_e)
{ // If error occurs, Exception causes automatic transaction rollback...
	$db = null; // Null connection to the database...
//	mail_errors($_e->getMessage()); // Mail errors accordingly.
	print_r ($_e->getMessage());
}

// $db = null; // Null connection variable closes connection.

?>