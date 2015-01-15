<?php
session_start();
ob_start();
if (empty($_SESSION['Auth']) and empty($_POST['Username']) and empty($_POST['Password'])) {
    echo '<h1>What is your Username and Password?</h1>
<form name="input" method="post">
Username: <input type="text" name="Username"><br>
Password: <input type="password" name="Password"><br>
<input type="submit" value="Submit">
</form>
';
    exit;
}
if (empty($_SESSION['Auth'])) {
    include('SecretPassword.php');
    if ($Username == $_POST['Username'] and $Password == $_POST['Password']) {
        $_SESSION['Auth'] = true;
        
    } else {
        header('location: /');
        exit;
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('location: /');
    exit;
}
