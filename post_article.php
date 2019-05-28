<?php

// Init session
session_start();

// check if user is logged in and allowed to view this page
if (!isset($_SESSION['login_flag']) || !$_SESSION['login_flag']) {
    header('Location: index.php');
}

// Fetch data input from submit form and sanitize
include_once 'classes/ProcessText.php';

$post_id = ProcessText::sanitize($_POST['post_id']);
$title = ProcessText::sanitize($_POST['title']);
$content = ProcessText::sanitize($_POST['content']);

// Include external class for querying database
include_once 'classes/DBConnection.php';

// Setup database connector object
$dataBaseConnect = new DBConnection();

// Check for error
if ($dataBaseConnect->errorCode() != 0) {
    $_SESSION['error_message'] = 'Error: Could not connect to database';
    header('Location: loggedin.php');
}

// Update article
$theQuery = $dataBaseConnect->doQuery('UPDATE articles SET title = \'' . $title . '\', content = \'' . $content . '\' WHERE id =\'' . $post_id . '\'');

$_SESSION['user_message'] = 'The article was updated';
header('Location: loggedin.php');