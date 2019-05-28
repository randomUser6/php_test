<?php

// Init session
session_start();

// Fetch data input from login form and sanitize
include_once 'classes/ProcessText.php';

$username = ProcessText::sanitize($_POST['user']);
$password = ProcessText::sanitize($_POST['password']);

// Include external class for querying database
include_once 'classes/DBConnection.php';

// Setup database connector object
$dataBaseConnect = new DBConnection();

// Check for error
if ($dataBaseConnect->errorCode() != 0) {
    $_SESSION['error_message'] = 'Error: Could not connect to database';
    header('Location: index.php');
}

// Search user table for matching form input
$theQuery = $dataBaseConnect->doQuery('SELECT password, id FROM user WHERE username = \'' . $username . '\'LIMIT 1');

if (empty($theQuery)) {

    $_SESSION['error_message'] = 'Error: No such user';
    header('Location: index.php');
} else {

    if (password_verify($password, $theQuery[0]['password'])) {

        $_SESSION['login_flag'] = true;
        $_SESSION['user_id'] = $theQuery[0]['id'];
        header('Location: loggedin.php');
    } else {

        $_SESSION['error_message'] = 'Error: Wrong password for user "' . $username . '"';
        header('Location: index.php');
    }
}