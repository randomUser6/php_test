<?php

// Init session
session_start();
?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>PHP-Test</title>
</head>

<body>
    <div class="login">
        <h2>Log in</h2>

        <?php
        // Check for error message after previous login attempt
        if (isset($_SESSION["error_message"])) {
            echo '<p class="error">' . $_SESSION["error_message"] . '</p>';
            unset($_SESSION["error_message"]);
        }
        ?>

        <form method="post" action="login.php">

            <input name="user" placeholder="Username" type="text"><br /><br />
            <input name="password" placeholder="Password" type="password">
            &nbsp;<button type="submit">Submit</button>

        </form>
    </div>

</body>

</html>