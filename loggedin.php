<?php

// Init session
session_start();

// check if user is logged in and allowed to view this page
if (!isset($_SESSION['login_flag']) || !$_SESSION['login_flag']) {
    header('Location: index.php');
}

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
$theQuery = $dataBaseConnect->doQuery('SELECT * FROM articles');

if (empty($theQuery)) {
    $_SESSION['user_message'] = 'No articles';
}

?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>PHP-Test: Logged in</title>
</head>

<body>

    &nbsp;&nbsp;<a href="logout.php">Log out</a>
    <h1>Articles</h1>

    <div class="articles">

        <?php
        // Check for error message 
        if (isset($_SESSION["error_message"])) {
            echo '<p class="error">' . $_SESSION["error_message"] . '</p>';
            unset($_SESSION["error_message"]);
        }

        // Check for user message
        if (isset($_SESSION["user_message"])) {
            echo '<p>' . $_SESSION["user_message"] . '</p>';
            unset($_SESSION["user_message"]);
        }

        // Go through each article in the data table and output to screen
        foreach ($theQuery as $row) {

            $id = $row['id'];
            $title = $row['title'];
            $user_id = $row['user_id'];
            $content = $row['content'];

            echo '<h2><a href="edit.php?id=' . $id . '">' . $title . '</a></h2>';

            $theName = $dataBaseConnect->doQuery('SELECT name FROM user WHERE id = \'' . $user_id . '\'');

            echo '<p>by: ' . $theName[0]['name'] . '</p>';
            
            // Shorten main content
            $trimmed_content = substr($content, 0, 100);
            echo '<p>' . $trimmed_content . '...</p>';
        }

        ?>


    </div>

</body>

</html>