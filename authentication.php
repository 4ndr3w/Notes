<?php
$publicNotes = explode("\n", trim(file_get_contents($basePath."/acl.list")));
$guestUser = false;

// You should remove the plaintext password here...
$users = array("username"=>sha1("password"));

function doAuthFor($target)
{
	global $publicNotes;
	global $guestUser;
	global $users;
	$target = urldecode($target);
	
	foreach ($publicNotes as $publicNote)
	{
		if ( $target == $publicNote)
		{
			$guestUser = true;
			break;
		}
	}
	
	if ( !isset($_SERVER['PHP_AUTH_USER']) && !$guestUser ) 
	{
	    header('WWW-Authenticate: Basic realm="Notes"');
	    header('HTTP/1.0 401 Unauthorized');
		die("You must be authenticated to view this page.");
	}
	else if ( $users[$_SERVER['PHP_AUTH_USER']] == sha1($_SERVER['PHP_AUTH_PW']) )
		$guestUser = false;
	else if ($guestUser)
		return;
	else
	{
	    header('WWW-Authenticate: Basic realm="Notes"');
	    header('HTTP/1.0 401 Unauthorized');
		die("You must authenticated to view this page.");
	}
		
}
?>