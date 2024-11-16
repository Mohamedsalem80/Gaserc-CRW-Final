<?php

session_start(); // Start the session
// Set the default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    $lang = ($_SESSION['lang'] == 'en') ? '' : '_ar';
	if (!isset($_SESSION['stage'])) {
		header("Location: followup{$lang}.php");
        exit();
	}
    $dashboard = ($_SESSION['stage'] == 1) ? 'dashboard16' : 'dashboard79';
    header("Location: {$dashboard}{$lang}.php");
    exit();
} else {
    header("Location: login{{$lang}}.php");
}

?>