<?php

// Init session
session_start();

// Set login to false and send to login page
$_SESSION['login_flag'] = false;
header('Location: index.php');
