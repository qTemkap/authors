<?php

require_once "Classes/Database.php";

use Classes\Database;

class Auth
{

    public function authorization($login, $pass)
    {
        $db = new Database();

        $login = mysqli_real_escape_string($db->DB, $login);
        $pass = mysqli_real_escape_string($db->DB, $pass);

        $query = sprintf("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$pass'");

        return $db->query($query);
    }

}

if (isset($_POST['username']) && isset($_POST['pass'])) {
    $login = trim($_POST['username']);
    $password = trim($_POST['pass']);
    $result = (new Auth())->authorization($_POST['username'], $_POST['pass']);

    if ($result) {
        setcookie('user_id', $result['id'], time() + 3600, "/");
        header('location: /author.php?author='.$result['id']);
    } else {
        header('location: /Login/login.php?error=true');
    }
}





