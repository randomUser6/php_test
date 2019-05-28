<?php

// Init session
session_start();

// check if user is logged in and allowed to view this page
if (!isset($_SESSION['login_flag']) || !$_SESSION['login_flag']) {
    header('Location: index.php');
}

// Fetch url input and sanitize
include_once 'classes/ProcessText.php';
$id = ProcessText::sanitize($_GET["id"]);

// Include external class for querying database
include_once 'classes/DBConnection.php';

// Setup database connector object
$dataBaseConnect = new DBConnection();

if ($dataBaseConnect->errorCode() != 0) {
    $_SESSION['error_message'] = 'Error: Could not connect to database';
    header('Location: loggedin.php');
}

// Search user table for matching form input
$theQuery = $dataBaseConnect->doQuery('SELECT id, title, content, user_id FROM articles WHERE id = \'' . $id . '\'LIMIT 1');

if (empty($theQuery)) {
    $_SESSION['error_message'] = 'Error: No valid article selected';
    header('Location: loggedin.php');
}
?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>PHP-Test: Edit article</title>
</head>

<body>

    &nbsp;&nbsp;<a href="logout.php">Log out</a>
    &nbsp;&nbsp;<a href="loggedin.php">Back to articles</a>

    <h1>Edit article</h1>
    <div class="articles">

        <form method="post" action="post_article.php">
            <?php

            // If logged in user is author of article allow change
            if ($_SESSION['user_id'] == $theQuery[0]['user_id']) {
                ?>
                <input type="hidden" name="post_id" value="<?php echo $theQuery[0]['id'] ?>">
                <textarea name="title" rows="1" cols="100"><?php echo $theQuery[0]['title'] ?></textarea><br><br>
                <textarea name="content" rows="13" cols="100"><?php echo $theQuery[0]['content'] ?></textarea><br><br>
                <button type="submit">Submit changes</button>

            <?php
        } else { // otherwise show read only fields
            echo '<p class="error">You may not edit articles submitted by another user.</p>';

            ?>
                <textarea rows="1" cols="100" readonly><?php echo $theQuery[0]['title'] ?></textarea><br><br>
                <textarea rows="13" cols="100" readonly><?php echo $theQuery[0]['content'] ?></textarea>
            <?php
        }



        ?>

        </form>

    </div>

</body>

</html>