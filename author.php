<?php

require_once "Classes/Database.php";

use Classes\Database;

if (isset($_GET['author'])) {
    $db = new Database();

    $userId = $_GET['author'];
    $query = "SELECT * FROM `users` WHERE `id` = '$userId'";
    $user = $db->query($query);

    $queryPosts = "SELECT * FROM `posts` WHERE `user_id` = '$userId'";
    $posts = $db->queryList($queryPosts);

    if ($user) {
        ?>

        <!DOCTYPE HTML>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="assets/css/style.css">
            <link rel="stylesheet" href="assets/css/author.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <title>КМПС</title>
        </head>
        <body>
        <div class="container">
            <div>
                <a href="/">
                    На главную
                </a>
            </div>
            <div class="section__header">
                <h2 class="section__page"><?php echo $user['name']; ?></h2>
            </div>
            <div class="posts">
                <div class="local-posts">
                    <?php if (isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id']) && $_COOKIE['user_id'] == $_GET['author']): ?>
                        <div style="text-align: center;">
                            <a href="#openModal" class="btn">Добавить статью</a>
                        </div>
                    <?php endif; ?>
                    <div class="list-local">
                        <?php
                        foreach ($posts as $post) {
                            echo "<div class='item-list'>";
                            if (!is_null($post['type'])) {
                                echo "<span class='type'>" . $post['type'] . "</span>";
                            }
                            if (!is_null($post['title'])) {
                                echo "<span class='title'>" . $post['title'] . "</span>";
                            }
                            if (!is_null($post['sub_title'])) {
                                echo "<span class='sub-title'>" . $post['sub_title'] . "</span>";
                            }
                            if (!is_null($post['text'])) {
                                echo "<span class='text'>" . $post['text'] . "</span>";
                            }
                            echo "</div>";
                        }

                        if (empty($posts)) {
                            echo "На данный момент нет локальных статей";
                        }
                        ?>
                    </div>
                    <div id="openModal" class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Добавление статьи</h3>
                                    <a href="#close" title="Close" id="close" class="close">×</a>
                                </div>
                                <div class="modal-body">
                                    <div class="input-form">
                                        <label for="title">Заголовок</label>
                                        <input type="text" id="title">
                                    </div>
                                    <div class="input-form">
                                        <label for="subTitle">Подзаголовок</label>
                                        <input type="text" id="subTitle">
                                    </div>
                                    <div class="input-form">
                                        <label for="type">Тип</label>
                                        <input type="text" id="type">
                                    </div>
                                    <div class="input-form">
                                        <label for="text">Содежрание</label>
                                        <textarea id="text" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                                <div style="text-align: center;">
                                    <a class="btn add-post">Добавить статью</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="platform-posts">
                    <div class="tabs">
                        <div class="tabs__nav">
                            <a class="tabs__link tabs__link_active" href="#content-1">Scopus</a>
                            <a class="tabs__link" href="#content-2" id="scholar">Scholar</a>
                        </div>
                        <div class="tabs__content">
                            <div class="tabs__pane tabs__pane_show" id="content-1">
                                <div id="loader1" class="lds-ring">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="list-scopus">
                                </div>
                            </div>
                            <div class="tabs__pane" id="content-2">
                                <div id="loader2" class="lds-ring">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="list-scholar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/author.js"></script>
        <?php if (isset($_COOKIE['user_id']) && !empty($_COOKIE['user_id']) && $_COOKIE['user_id'] == $_GET['author']): ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var scrollbar = document.body.clientWidth - window.innerWidth + 'px';
                    console.log(scrollbar);
                    document.querySelector('[href="#openModal"]').addEventListener('click', function () {
                        document.body.style.overflow = 'hidden';
                        document.querySelector('#openModal').style.marginLeft = scrollbar;
                    });
                    document.querySelector('[href="#close"]').addEventListener('click', function () {
                        document.body.style.overflow = 'visible';
                        document.querySelector('#openModal').style.marginLeft = '0px';
                    });
                });
            </script>
        <?php endif; ?>
        <script>
            var $tabs = function (target) {
                var
                    _elemTabs = (typeof target === 'string' ? document.querySelector(target) : target),
                    _eventTabsShow,
                    _showTab = function (tabsLinkTarget) {
                        var tabsPaneTarget, tabsLinkActive, tabsPaneShow;
                        tabsPaneTarget = document.querySelector(tabsLinkTarget.getAttribute('href'));
                        tabsLinkActive = tabsLinkTarget.parentElement.querySelector('.tabs__link_active');
                        tabsPaneShow = tabsPaneTarget.parentElement.querySelector('.tabs__pane_show');
                        // если следующая вкладка равна активной, то завершаем работу
                        if (tabsLinkTarget === tabsLinkActive) {
                            return;
                        }
                        // удаляем классы у текущих активных элементов
                        if (tabsLinkActive !== null) {
                            tabsLinkActive.classList.remove('tabs__link_active');
                        }
                        if (tabsPaneShow !== null) {
                            tabsPaneShow.classList.remove('tabs__pane_show');
                        }
                        // добавляем классы к элементам (в завимости от выбранной вкладки)
                        tabsLinkTarget.classList.add('tabs__link_active');
                        tabsPaneTarget.classList.add('tabs__pane_show');
                        document.dispatchEvent(_eventTabsShow);
                    },
                    _switchTabTo = function (tabsLinkIndex) {
                        var tabsLinks = _elemTabs.querySelectorAll('.tabs__link');
                        if (tabsLinks.length > 0) {
                            if (tabsLinkIndex > tabsLinks.length) {
                                tabsLinkIndex = tabsLinks.length;
                            } else if (tabsLinkIndex < 1) {
                                tabsLinkIndex = 1;
                            }
                            _showTab(tabsLinks[tabsLinkIndex - 1]);
                        }
                    };

                _eventTabsShow = new CustomEvent('tab.show', {detail: _elemTabs});

                _elemTabs.addEventListener('click', function (e) {
                    var target = e.target.closest('.tabs__link');
                    // завершаем выполнение функции, если кликнули не по ссылке
                    if (!target) {
                        return;
                    }
                    // отменяем стандартное действие
                    e.preventDefault();
                    _showTab(target);
                });

                return {
                    showTab: function (target) {
                        _showTab(target);
                    },
                    switchTabTo: function (index) {
                        _switchTabTo(index);
                    }
                }
            };

            $tabs('.tabs');
        </script>
        </body>
        </html>

        <?php
    } else {
        header('location: /');
        exit();
    }
    ?>


    <?php

} else {
    header('location: /');
    exit();
}

?>