<?php

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

use Classes\Scopus;
use Classes\Scholar;
use Classes\Database;

if (isset($_POST['userId'])) {
    $db = new Database();
    $userId = $_POST['userId'];
    $query = "SELECT * FROM `users` WHERE `id` = '$userId'";
    $user = $db->query($query);

    if($user) {
        if (isset($_POST['type'])) {
            switch ($_POST['type']) {
                case 'scopus':
                    echo (new Scopus)->sendCurl($user['link_scopus'], $_POST)->getPosts();
                    break;
                case 'scholar':
                    echo (new Scholar)->sendCurl($user['link_scholar'])->getPosts();
                    break;
                default:
                    echo "";
                    break;
            }
        }
    } else {
        echo "";
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'addPost') {

    if (isset($_POST['post'])) {
        $attributes = [];
        $values = [];

        foreach ($_POST['post'] as $key => $attribute) {
            if (!empty($attribute)) {
                array_push($attributes, $key);
                array_push($values, $attribute);
            }
        }

        if(!empty($attributes) && !empty($values)) {
            array_push($attributes, 'user_id');
            array_push($values, '1');
            $db = new Database();
            $strQuery = "INSERT INTO `posts` (".implode(',', $attributes).") VALUES ("."'".implode ( "', '", $values)."'".")";

            echo $db->insert($strQuery);
        }
    }
}


