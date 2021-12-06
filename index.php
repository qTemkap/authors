<?php

require_once "Classes/Database.php";

use Classes\Database;
header( 'Content-Type: text/html; charset=utf-8' );
$db = new Database();
$query = "SELECT * FROM `users` WHERE 1";
$authors = $db->queryList($query);

$authorsArray = array_chunk($authors, 5);
?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/main.js"></script>
    <title>КМПС</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<header class="header">
    <div class="container">
        <div class="header__inner">
            <div class="header__logo">КМПС</div>

            <nav class="nav">
                <?php if(isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id'])): ?>
                    <a class="nav__link" href="exit.php"> Выход </a>
                <?php else: ?>
                    <a class="nav__link" href="Login/login.php"> Авторизация </a>
                <?php endif ?>
            </nav>
        </div>
    </div>
</header>


<div class="intro">
    <div class="container">
        <div class="intro__inner">
            <h1 class="intro__title">Добро пожаловать в КМПС</h1>

            <a class="btn" href="#"> Читать больше </a>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">

        <div class="section__header">
            <h2 class="section__suptitle"> Список преподавателей </h2>
            <h3 class="section__title"> Здесь расположены ссылки на статьи </h3>
        </div>

        <?php
            foreach ($authorsArray as $list):
        ?>
            <div class="about">
                <?php
                    foreach ($list as $item):
                ?>
                    <div class="about__item">
                        <div class="about__img">
                            <img src="<?php echo (!is_null($item['image']))? $item['image'] : 'assets/images/profile.png'; ?>" alt="">
                            <h3><a href="author.php?author=<?php echo $item['id'];?>"><?php echo $item['short_name'];?></a></h3>
                        </div>
                    </div>
                <?php
                    endforeach;
                ?>
            </div>
        <?php
            endforeach;
        ?>
    </div>
</body>
</html>